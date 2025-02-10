<?php

namespace App\Orchid\Screens\Bulk;

use Exception;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use App\Models\Assessment\RMSD;
use App\Models\Assessment\Protection as ProtectionModel;
use App\Models\Assessment\Threat;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Toast;
use Orchid\Support\Facades\Layout;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use App\Orchid\Layouts\Listener\Bulk\ProtectionBulk;
use App\Orchid\Layouts\Management\GlobalAssetSearchLayout;
use App\Orchid\Layouts\Bulk\Protection\Protection as ProtectionLayout;

class Protection extends Screen
{
    public $asset;   
    public $protection;

    /**
     * @var string
     */
    public $searchQuery = '';

    public function query(): iterable
    {
        $query = ProtectionModel::with([
            'threat' => function($query) {
                $query->with(['asset' => function($query) {
                    $query->with('valuation');
                }]);
            },
            'rmsd' => function($query) {
                $query->select('id', 'threat_id', 'risk_level', 'risk_level_5' , 'safeguard_id');
            }
        ]);

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

        $protections = $query->get();

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
            'protection' => $protections,
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
        return redirect()->route('platform.bulk.protection', ['filter' => ['search' => $search, 'type' => $type]]);
    }

    public function name(): ?string
    {
        return 'Protection Strategy and Decision ';
    }

    public function description(): ?string
    {
        return 'Assess and manage protection strategies and decisions associated with assets and their corresponding threats. This module allows you to identify, categorize, and track vulnerabilities to better understand and mitigate potential risks.';
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
            ProtectionLayout::class,

            Layout::modal('modalProtection', [
                ProtectionBulk::class,
            ])->deferred('loadProtectionModal'),
        ];
    }

    public function save(Request $request)
    {
        $protection_id = $request->input('protection');
        try {
            $protection = ProtectionModel::find($protection_id);
            
            if ($protection) {
                $protection->update([
                    'id' => $protection_id,
                    'protection_strategy' => $request->input('protection_strategy') ?? $protection->protection_strategy,
                    'protection_id' => $request->input('protection_id') ?? $protection->protection_id,
                    'decision' => $request->input('decision') ?? $protection->decision
                ]);
            } else {
               Toast::error('An error occurred while saving the protection assessment.');
            }

            Toast::info('Protection assessment saved successfully.');
        } catch (ValidationException $e) {
            Toast::error('Validation error: ' . $e->getMessage());
        } catch (QueryException $e) {
            Toast::error('Database error: Unable to save protection assessment.');
        } catch (Exception $e) {
            Toast::error('An unexpected error occurred while saving the protection assessment.');
        }
    }

    public function next(){
        return redirect()->route('platform.bulk.treatment');
    }

    public function loadProtectionModal(ProtectionModel $protection): array
    {
        return [
            'protection_strategy' => $protection->protection_strategy,
            'protection_id' => $protection->protection_id,
            'decision' => $protection->decision,
        ];
    }
}