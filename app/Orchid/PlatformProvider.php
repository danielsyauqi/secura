<?php

declare(strict_types=1);

namespace App\Orchid;

use Orchid\Support\Color;
use Orchid\Platform\Dashboard;
use Orchid\Screen\Actions\Menu;
use Orchid\Platform\ItemPermission;
use Illuminate\Support\Facades\Auth;
use Orchid\Platform\OrchidServiceProvider;

class PlatformProvider extends OrchidServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @param Dashboard $dashboard
     *
     * @return void
     */
    public function boot(Dashboard $dashboard): void
    {
        parent::boot($dashboard);
        $dashboard->registerResource('stylesheets', asset('css/custom.css'));
        $dashboard->registerResource('scripts', asset('js/custom.js'));
        // ...
    }

    /**
     * Register the application menu.
     *
     * @return Menu[]
     */
    public function menu(): array
    
    {

        $userPermissions = Auth::user()->permissions; // Get current user's permissions (assuming the permissions column is a JSON field)

        return [
            Menu::make('Dashboard')
                ->icon('bs.columns-gap')
                ->title('General')
                ->route(config('platform.index')),
            
                
            Menu::make('SecuRA Management ')
            ->icon('bs.folder')
            ->list([
                Menu::make('ISMS/ISO Management')->route('platform.management.SecuraManagement'),
                Menu::make('Team Management')->route('platform.management.TeamManagement'),
            ])->divider(),

            Menu::make('Asset and Valuation')
                ->title('Risk Assessment Wizard')
                ->icon('bs.layers')
                ->list([

                    Menu::make('Asset Management')
                    ->route('platform.management.AssetManagement'),

                    Menu::make('Valuation of Asset')
                    ->route('platform.assessment.valuation', ['id' => request()->route('id')])
                ]),

            Menu::make('Risk Assessment')
                ->icon('bs.file-earmark-ruled')
                ->list([
                    Menu::make('Threats Classification')
                        ->route('platform.assessment.threat', ['id' => request()->route('id'), 'threat_id' => request()->route('threat_id')]),

                    Menu::make('Risk Management and Safeguard Data')
                        ->route('platform.assessment.rmsd', ['id' => request()->route('id'), 'threat_id' => request()->route('threat_id')]),

                    Menu::make('Risk Calculation')
                        ->route('platform.assessment.risk', ['id' => request()->route('id'), 'threat_id' => request()->route('threat_id')]),

                    Menu::make('Protection Strategy and Decision')
                        ->route('platform.assessment.protection', ['id' => request()->route('id'), 'threat_id' => request()->route('threat_id')]),

                    Menu::make('Risk Treatment Plan')
                        ->route('platform.assessment.treatment', ['id' => request()->route('id'), 'threat_id' => request()->route('threat_id')]),

                ]),

            Menu::make('Bulk Edit')
                ->icon('bs.table')
                ->list([
                    Menu::make('Valuation of Asset')
                        ->route('platform.bulk.valuation'),

                    Menu::make('Threat Classification')
                        ->route('platform.bulk.threat'),

                    Menu::make('Asset Vulnerability')
                        ->route('platform.bulk.vulnerable'),

                    Menu::make('Asset Safeguard')
                        ->route('platform.bulk.safeguard'),

                    Menu::make('Asset Impact')
                        ->route('platform.bulk.impact'),

                    Menu::make('Risk Level Calculation')
                        ->route('platform.bulk.riskCalculation'),

                    Menu::make('Protection Strategy and Decision')
                        ->route('platform.bulk.protection'),

                    Menu::make('Risk Treatment Plan')
                        ->route('platform.bulk.treatment'),

                ]),
                
            Menu::make('Print Report')
                ->icon('bs.printer')
                ->route('platform.report.printReport')->divider(),
            

            Menu::make(__('Users'))
                ->icon('bs.people')
                ->route('platform.systems.users')
                ->permission('platform.systems.users')
                ->title(__('Access Controls')),

            Menu::make(__('Roles'))
                ->icon('bs.shield')
                ->route('platform.systems.roles')
                ->permission('platform.systems.roles')
                ->divider(),

            Menu::make('Organization Profile')
                ->title('System')
                ->icon('bs.gear-fill')
                ->route('platform.organizational.profile'),
                
            Menu::make('Log Out')
                ->icon('bs.door-open')
                ->route('platform.main', ['logout' => 'true']),
                
            Menu::make('Support Desk')
                ->icon('bs.exclamation-square-fill')
                ->target('_blank')
                ->href('http://sysdesk.nuclearmalaysia.gov.my/'),

            // Menu::make('Orchid Elements')
            //     ->icon('bs.plus')
            //     ->list([
            //         Menu::make('Sample Screen')
            //         ->icon('bs.collection')
            //         ->route('platform.example')
            //         ->badge(fn () => 6),
    
            //         Menu::make('Form Elements')
            //             ->icon('bs.card-list')
            //             ->route('platform.example.fields')
            //             ->active('*/examples/form/*'),
    
            //         Menu::make('Overview Layouts')
            //             ->icon('bs.window-sidebar')
            //             ->route('platform.example.layouts'),
    
            //         Menu::make('Grid System')
            //             ->icon('bs.columns-gap')
            //             ->route('platform.example.grid'),
    
            //         Menu::make('Charts')
            //             ->icon('bs.bar-chart')
            //             ->route('platform.example.charts'),
    
            //         Menu::make('Cards')
            //             ->icon('bs.card-text')
            //             ->route('platform.example.cards'),
    
            //     ]),
        ];
    }

    /**
     * Register permissions for the application.
     *
     * @return ItemPermission[]
     */
    public function permissions(): array
    {
        return [
            ItemPermission::group(__('System'))
                ->addPermission('platform.systems.roles', __('Roles'))
                ->addPermission('platform.systems.users', __(key: 'Users')),
        ];
    }

    /**
     * Log out the user.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logOut()
    {
        \Illuminate\Support\Facades\Auth::logout();
    }
}
