<?php

namespace App\Orchid\Screens\Bulk;

use Exception;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use App\Models\Assessment\RMSD;
use App\Models\Assessment\Threat;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Toast;
use Orchid\Support\Facades\Layout;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use App\Orchid\Layouts\Listener\Bulk\VulnerableBulk;
use App\Orchid\Layouts\Management\GlobalAssetSearchLayout;
use App\Orchid\Layouts\Bulk\Vulnerable\Vulnerable as VulnerableLayout;

class Vulnerable extends Screen
{
    public $asset;   
    public $vulnerable;

    /**
     * @var string
     */
    public $searchQuery = '';

    public function query(): iterable
    {
        $query = RMSD::with(['threat' => function($query) {
            $query->with('asset');
        }]);

        $search = request('filter.search');
        $selectedType = request('filter.type');

        if ($search) {
            $query->whereHas('threat.asset', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        if ($selectedType) {
            $query->whereHas('threat.asset', function ($q) use ($selectedType) {
                $q->where('type', $selectedType);
            });
        }

        $rmsd = $query->get();

        $assetTypes = [
            'hardware' => 'Hardware',
            'software' => 'Software',
            'work' => 'Work Process',
            'data' => 'Data and Information',
            'service' => 'Services',
            'resource' => 'Human Resources',
            'premise' => 'Premise',
        ];

        return [
            'vulnerable' => $rmsd,
            'assetTypes' => $assetTypes,
            'selectedType' => $selectedType,
            'filter' => [
                'search' => $search,
                'type' => $selectedType
            ],
        ];
    }

    public function search(): RedirectResponse
    {
        $search = request('filter.search');
        $type = request('filter.type');
        return redirect()->route('platform.bulk.vulnerable', ['filter' => ['search' => $search, 'type' => $type]]);
    }

    public function name(): ?string
    {
        return 'Asset Vulnerability Assessment';
    }

    public function description(): ?string
    {
        return 'Assess and manage vulnerabilities associated with assets and their corresponding threats. This module allows you to identify, categorize, and track vulnerabilities to better understand and mitigate potential risks.';
    }

    public function commandBar(): iterable
    {
        return [
            Button::make(__('Next'))
                ->icon('bs.arrow-bar-right')
                ->method('next'),
        ];
    }

    public function layout(): array
    {
        return [
            GlobalAssetSearchLayout::class,
            VulnerableLayout::class,

            Layout::modal('modalVulnerable', [
                VulnerableBulk::class,
            ])->deferred('loadVulnerableModal'),
        ];
    }

    public function save(Request $request)
    {
        $rmsd_id = $request->input('vulnerable');
        try {
            $validated = $request->validate([
                'vuln_group' => 'required|string',
                'vuln_name' => 'required|string',
            ]);

            $rmsd = RMSD::find($rmsd_id);
            
            if ($rmsd) {
                $rmsd->update([
                    'id' => $rmsd_id,
                    'vuln_group' => $validated['vuln_group'],
                    'vuln_name' => $validated['vuln_name'],
                ]);
            } else {
                RMSD::create([
                    'id' => $rmsd_id,
                    'vuln_group' => $validated['vuln_group'],
                    'vuln_name' => $validated['vuln_name'],
                ]);
            }

            Toast::info('Vulnerability assessment saved successfully.');
        } catch (ValidationException $e) {
            Toast::error('Validation error: ' . $e->getMessage());
        } catch (QueryException $e) {
            Toast::error('Database error: Unable to save vulnerability assessment.');
        } catch (Exception $e) {
            Toast::error('An unexpected error occurred while saving the vulnerability assessment.');
        }
    }

    public function next(){
        return redirect()->route('platform.bulk.safeguard');
    }

    public function loadVulnerableModal(RMSD $vulnerable): array
    {
        return [
            'vuln_group' => $vulnerable->vuln_group,
            'vuln_name' => $vulnerable->vuln_name,
        ];
    }
}