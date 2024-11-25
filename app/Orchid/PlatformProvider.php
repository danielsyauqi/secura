<?php

declare(strict_types=1);

namespace App\Orchid;

use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\OrchidServiceProvider;
use Orchid\Screen\Actions\Menu;
use Orchid\Support\Color;

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
     * Check if the route ID is present.
     *
     * @return bool
     */
    private function isRouteIdPresent(): bool
    {
        return request()->route('id') !== null;
    }

    private function isRouteThreatIDPresent(): bool
    {
        return request()->route('threat_id') !== null;
    }


    /**
     * Register the application menu.
     *
     * @return Menu[]
     */
    public function menu(): array
    {
        return [
            Menu::make('Get Started')
                ->icon('bs.book')
                ->title('Navigation')
                ->route(config('platform.index')),

            Menu::make('Asset and Valuation')
                ->icon('bs.layers')
                ->route('platform.management.AssetManagement')
                ->list([

                    Menu::make('Asset Management')
                    ->route('platform.management.AssetManagement'),

                    Menu::make('Valuation of Asset')
                    ->route('platform.assessment.valuation', ['id' => request()->route('id')])
                    ->canSee($this->isRouteIdPresent()),
                ]),

            Menu::make('Risk Assessment')
                ->icon('bs.file-earmark-ruled')
                ->list([
                    Menu::make('Threats Classification')
                        ->route('platform.assessment.threat', ['id' => request()->route('id')]),

                    Menu::make('Risk Management and Safeguard Data')
                        ->route('platform.assessment.rmsd', ['id' => request()->route('id'), 'threat_id' => request()->route('threat_id')])
                        ->canSee($this->isRouteThreatIDPresent()),
                ])->canSee($this->isRouteIdPresent()),
                

            Menu::make('SIMS Management ')
                ->icon('bs.folder')
                ->route('platform.management.SimsManagement')
                ->list([
                    Menu::make('ISMS/ISO Management')->route('platform.management.SimsManagement'),
                    Menu::make('Team Management')->route('platform.management.TeamManagement'),
                ]),

            Menu::make('Sample Screen')
                ->icon('bs.collection')
                ->route('platform.example')
                ->badge(fn () => 6),

            Menu::make('Form Elements')
                ->icon('bs.card-list')
                ->route('platform.example.fields')
                ->active('*/examples/form/*'),

            Menu::make('Overview Layouts')
                ->icon('bs.window-sidebar')
                ->route('platform.example.layouts'),

            Menu::make('Grid System')
                ->icon('bs.columns-gap')
                ->route('platform.example.grid'),

            Menu::make('Charts')
                ->icon('bs.bar-chart')
                ->route('platform.example.charts'),

            Menu::make('Cards')
                ->icon('bs.card-text')
                ->route('platform.example.cards')
                ->divider(),

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

            Menu::make('Documentation')
                ->title('Docs')
                ->icon('bs.box-arrow-up-right')
                ->url('https://orchid.software/en/docs')
                ->target('_blank'),

            Menu::make('Changelog')
                ->icon('bs.box-arrow-up-right')
                ->url('https://github.com/orchidsoftware/platform/blob/master/CHANGELOG.md')
                ->target('_blank')
                ->badge(fn () => Dashboard::version(), Color::DARK),
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
}
