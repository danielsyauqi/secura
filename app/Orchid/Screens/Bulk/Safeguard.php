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
use App\Orchid\Layouts\Listener\Bulk\SafeguardBulk;
use App\Orchid\Layouts\Management\GlobalAssetSearchLayout;
use App\Orchid\Layouts\Bulk\Safeguard\Safeguard as SafeguardLayout;

class Safeguard extends Screen
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
            'safeguard' => $rmsd,
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
        return redirect()->route('platform.bulk.safeguard', ['filter' => ['search' => $search, 'type' => $type]]);
    }

    public function name(): ?string
    {
        return 'Asset Safeguard Assessment';
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
            SafeguardLayout::class,

            Layout::modal('modalSafeguard', [
                SafeguardBulk::class,
            ])->deferred('loadSafeguardModal'),
        ];
    }

    public function save(Request $request)
    {
        $rmsd_id = $request->input('safeguard');
        try {
            $validated = $request->validate([
                'safeguard_group' => 'required|string',
                'safeguard_id' => 'required|string',
            ]);

            $rmsd = RMSD::find($rmsd_id);
            
            if ($rmsd) {
                $rmsd->update([
                    'id' => $rmsd_id,
                    'safeguard_group' => $validated['safeguard_group'],
                    'safeguard_id' => $validated['safeguard_id'],
                ]);
            } else {
                RMSD::create([
                    'id' => $rmsd_id,
                    'safeguard_group' => $validated['safeguard_group'],
                    'safeguard_id' => $validated['safeguard_id'],
                ]);
            }

            Toast::info('Safeguard assessment saved successfully.');
        } catch (ValidationException $e) {
            Toast::error('Validation error: ' . $e->getMessage());
        } catch (QueryException $e) {
            Toast::error('Database error: Unable to save safeguard assessment.');
        } catch (Exception $e) {
            Toast::error('An unexpected error occurred while saving the safeguard assessment.');
        }
    }

    public function next(){
        return redirect()->route('platform.bulk.impact');
    }

    public function loadSafeguardModal(RMSD $safeguard): array
    {
        return [
            'safeguard_group' => $safeguard->safeguard_group,
            'safeguard_id' => $safeguard->safeguard_id,
        ];
    }
}