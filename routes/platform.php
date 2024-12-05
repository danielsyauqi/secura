<?php

declare(strict_types=1);

use App\Http\Controllers\detailRA;
use App\Http\Controllers\detailRA_5;
use App\Http\Controllers\highRecommend;
use App\Http\Controllers\highRecommend_5;
use App\Http\Controllers\summary;
use App\Http\Controllers\summary_5;
use App\Http\Controllers\treatmentAppendix;
use App\Http\Controllers\treatmentAppendix_5;
use App\Http\Controllers\treatmentSummary;
use App\Http\Controllers\treatmentSummary_5;
use App\Http\Controllers\users;
use App\Orchid\Screens\Assessment\Protection;
use App\Orchid\Screens\Assessment\RMSD;
use App\Orchid\Screens\Assessment\RiskCalculation;
use App\Orchid\Screens\Assessment\Threat;
use App\Orchid\Screens\Assessment\Treatment;
use App\Orchid\Screens\Assessment\Valuation;
use App\Orchid\Screens\Examples\ExampleActionsScreen;
use App\Orchid\Screens\Examples\ExampleCardsScreen;
use App\Orchid\Screens\Examples\ExampleChartsScreen;
use App\Orchid\Screens\Examples\ExampleFieldsAdvancedScreen;
use App\Orchid\Screens\Examples\ExampleFieldsScreen;
use App\Orchid\Screens\Examples\ExampleGridScreen;
use App\Orchid\Screens\Examples\ExampleLayoutsScreen;
use App\Orchid\Screens\Examples\ExampleScreen;
use App\Orchid\Screens\Examples\ExampleTextEditorsScreen;
use App\Orchid\Screens\Management\AssetManagement;
use App\Orchid\Screens\Management\SimsManagement;
use App\Orchid\Screens\Management\TeamManagement;
use App\Orchid\Screens\PlatformScreen;
use App\Orchid\Screens\Report\PrintReport;
use App\Orchid\Screens\Role\RoleEditScreen;
use App\Orchid\Screens\Role\RoleListScreen;
use App\Orchid\Screens\User\UserEditScreen;
use App\Orchid\Screens\User\UserListScreen;
use App\Orchid\Screens\User\UserProfileScreen;
use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Trail;

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These`
| routes are loaded by the RouteServiceProvider within a group which
| contains the need "dashboard" middleware group. Now create something great!
|
*/



// Main
Route::screen('/main/{logout?}', PlatformScreen::class)
    ->name('platform.main');

// Platform > Profile
Route::screen('profile', UserProfileScreen::class)
    ->name('platform.profile')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Profile'), route('platform.profile')));

// Platform > System > Users > User
Route::screen('users/{user}/edit', UserEditScreen::class)
    ->name('platform.systems.users.edit')
    ->breadcrumbs(fn (Trail $trail, $user) => $trail
        ->parent('platform.systems.users')
        ->push($user->name, route('platform.systems.users.edit', $user)));

// Platform > System > Users > Create
Route::screen('users/create', UserEditScreen::class)
    ->name('platform.systems.users.create')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.systems.users')
        ->push(__('Create'), route('platform.systems.users.create')));

// Platform > System > Users
Route::screen('users', UserListScreen::class)
    ->name('platform.systems.users')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Users'), route('platform.systems.users')));

// Platform > System > Roles > Role
Route::screen('roles/{role}/edit', RoleEditScreen::class)
    ->name('platform.systems.roles.edit')
    ->breadcrumbs(fn (Trail $trail, $role) => $trail
        ->parent('platform.systems.roles')
        ->push($role->name, route('platform.systems.roles.edit', $role)));

// Platform > System > Roles > Create
Route::screen('roles/create', RoleEditScreen::class)
    ->name('platform.systems.roles.create')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.systems.roles')
        ->push(__('Create'), route('platform.systems.roles.create')));

// Platform > System > Roles
Route::screen('roles', RoleListScreen::class)
    ->name('platform.systems.roles')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Roles'), route('platform.systems.roles')));

// Example...
Route::screen('example', ExampleScreen::class)
    ->name('platform.example')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Example Screen'));

Route::screen('/examples/form/fields', ExampleFieldsScreen::class)->name('platform.example.fields');
Route::screen('/examples/form/advanced', ExampleFieldsAdvancedScreen::class)->name('platform.example.advanced');
Route::screen('/examples/form/editors', ExampleTextEditorsScreen::class)->name('platform.example.editors');
Route::screen('/examples/form/actions', ExampleActionsScreen::class)->name('platform.example.actions');

Route::screen('/examples/layouts', ExampleLayoutsScreen::class)->name('platform.example.layouts');
Route::screen('/examples/grid', ExampleGridScreen::class)->name('platform.example.grid');
Route::screen('/examples/charts', ExampleChartsScreen::class)->name('platform.example.charts');
Route::screen('/examples/cards', ExampleCardsScreen::class)->name('platform.example.cards');

//SIMS Route (Management)
Route::screen('/management/SimsManagement', SimsManagement::class)->name('platform.management.SimsManagement');
Route::screen('/management/TeamManagement', TeamManagement::class)->name('platform.management.TeamManagement');
Route::screen('/management/AssetManagement/{id?}', AssetManagement::class)->name('platform.management.AssetManagement');

//SIMS Route (Steps Form)
Route::screen('assessment/Valuation/{id?}', Valuation::class)->name('platform.assessment.valuation');
Route::screen('assessment/Threat/{id?}/{threat_id?}', Threat::class)->name('platform.assessment.threat');
Route::screen('assessment/threat/{id?}/{threat_id?}/edit', Threat::class)
    ->name('platform.assessment.threat.edit');

Route::screen('assessment/RMSD/{id?}/{threat_id?}', RMSD::class)->name('platform.assessment.rmsd');
Route::screen('assessment/RiskCalc/{id?}/{threat_id?}', RiskCalculation::class)->name('platform.assessment.risk');
Route::screen('assessment/Protection/{id?}/{threat_id?}', Protection::class)->name('platform.assessment.protection');
Route::screen('assessment/Treatment/{id?}/{threat_id?}', Treatment::class)->name('platform.assessment.treatment');

Route::screen('report/PrintReport', PrintReport::class)->name('platform.report.printReport');
Route::get ('/detail-ra', [detailRA::class, 'detailRA'])->name('detailRA');
Route::get ('/summary', [summary::class, 'summary'])->name('summary');
Route::get ('/highRecommend', [highRecommend::class, 'highRecommend'])->name('highRecommend');
Route::get ('/treatmentAppendix', [treatmentAppendix::class, 'treatmentAppendix'])->name('treatmentAppendix');
Route::get ('/treatmentsummary', [treatmentSummary::class, 'treatmentSummary'])->name('treatmentSummary');

Route::get ('/detail-ra5', [detailRA_5::class, 'detailRA_5'])->name('detailRA_5');
Route::get ('/summary5', [summary_5::class, 'summary_5'])->name('summary_5');
Route::get ('/highRecommend5', [highRecommend_5::class, 'highRecommend_5'])->name('highRecommend_5');
Route::get ('/treatmentAppendix5', [treatmentAppendix_5::class, 'treatmentAppendix_5'])->name('treatmentAppendix_5');
Route::get ('/treatmentsummary5', [treatmentsummary_5::class, 'treatmentsummary_5'])->name('treatmentsummary_5');








use Illuminate\Support\Facades\Log;

Route::get('/users', function() {
    Log::info('Users route accessed');
});








// In routes/api.php
Route::post('/api/threat-details', [Threat::class, 'getThreatDetails']);




