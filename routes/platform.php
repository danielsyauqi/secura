<?php

declare(strict_types=1);

use App\Http\Controllers\{
    detailRA, detailRA_5,
    highRecommend, highRecommend_5,
    summary, summary_5,
    treatmentAppendix, treatmentAppendix_5,
    treatmentSummary, treatmentSummary_5
};
use App\Orchid\Screens\Assessment\{
    Protection, RMSD, RiskCalculation,
    Threat, Treatment, Valuation
};
use App\Orchid\Screens\Management\{
    AssetManagement, OrgProfile,
    SecuraManagement, TeamManagement
};
use App\Orchid\Screens\{
    PlatformScreen,
    Role\RoleEditScreen,
    Role\RoleListScreen,
    User\UserEditScreen,
    User\UserListScreen,
    User\UserProfileScreen,
    Report\PrintReport
};

use App\Orchid\Screens\Bulk\{
    Valuation as ValuationBulk,
    Threat as ThreatBulk,
    Vulnerable as VulnerableBulk,
    Safeguard as SafeguardBulk,
    Impact as ImpactBulk,
    RiskCalculation as RiskCalculationBulk,
    Protection as ProtectionBulk,
    Treatment as TreatmentBulk
};
use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Trail;

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the need "dashboard" middleware group.
|
*/

// Main Dashboard
Route::screen('/main/{logout?}', PlatformScreen::class)
    ->name('platform.main');

// User Profile Routes
Route::screen('profile', UserProfileScreen::class)
    ->name('platform.profile')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Profile'), route('platform.profile')));

// User Management Routes
Route::prefix('users')->group(function () {
    Route::screen('/', UserListScreen::class)
        ->name('platform.systems.users')
        ->breadcrumbs(fn (Trail $trail) => $trail
            ->parent('platform.index')
            ->push(__('Users'), route('platform.systems.users')));

    Route::screen('/create', UserEditScreen::class)
        ->name('platform.systems.users.create')
        ->breadcrumbs(fn (Trail $trail) => $trail
            ->parent('platform.systems.users')
            ->push(__('Create'), route('platform.systems.users.create')));

    Route::screen('/{user}/edit', UserEditScreen::class)
        ->name('platform.systems.users.edit')
        ->breadcrumbs(fn (Trail $trail, $user) => $trail
            ->parent('platform.systems.users')
            ->push($user->name, route('platform.systems.users.edit', $user)));
});

// Role Management Routes
Route::prefix('roles')->group(function () {
    Route::screen('/', RoleListScreen::class)
        ->name('platform.systems.roles')
        ->breadcrumbs(fn (Trail $trail) => $trail
            ->parent('platform.index')
            ->push(__('Roles'), route('platform.systems.roles')));

    Route::screen('/create', RoleEditScreen::class)
        ->name('platform.systems.roles.create')
        ->breadcrumbs(fn (Trail $trail) => $trail
            ->parent('platform.systems.roles')
            ->push(__('Create'), route('platform.systems.roles.create')));

    Route::screen('/{role}/edit', RoleEditScreen::class)
        ->name('platform.systems.roles.edit')
        ->breadcrumbs(fn (Trail $trail, $role) => $trail
            ->parent('platform.systems.roles')
            ->push($role->name, route('platform.systems.roles.edit', $role)));
});

// Management Routes
Route::prefix('management')->group(function () {
    Route::screen('/SecuraManagement', SecuraManagement::class)
        ->name('platform.management.SecuraManagement');
    Route::screen('/TeamManagement', TeamManagement::class)
        ->name('platform.management.TeamManagement');
    Route::screen('/AssetManagement/{id?}', AssetManagement::class)
        ->name('platform.management.AssetManagement');
});

// Assessment Routes
Route::prefix('assessment')->group(function () {
    Route::screen('Valuation/{id?}', Valuation::class)
        ->name('platform.assessment.valuation');
    Route::screen('Threat/{id?}/{threat_id?}', Threat::class)
        ->name('platform.assessment.threat');
    Route::screen('threat/{id?}/{threat_id?}/edit', Threat::class)
        ->name('platform.assessment.threat.edit');
    Route::screen('RMSD/{id?}/{threat_id?}', RMSD::class)
        ->name('platform.assessment.rmsd');
    Route::screen('RiskCalc/{id?}/{threat_id?}', RiskCalculation::class)
        ->name('platform.assessment.risk');
    Route::screen('Protection/{id?}/{threat_id?}', Protection::class)
        ->name('platform.assessment.protection');
    Route::screen('Treatment/{id?}/{threat_id?}', Treatment::class)
        ->name('platform.assessment.treatment');
});

// Report Routes
Route::prefix('report')->group(function () {
    Route::screen('PrintReport', PrintReport::class)
        ->name('platform.report.printReport');
    Route::get('/detail-ra', [detailRA::class, 'detailRA'])
        ->name('detailRA');
    Route::get('/summary', [summary::class, 'summary'])
        ->name('summary');
    Route::get('/highRecommend', [highRecommend::class, 'highRecommend'])
        ->name('highRecommend');
    Route::get('/treatmentAppendix', [treatmentAppendix::class, 'treatmentAppendix'])
        ->name('treatmentAppendix');
    Route::get('/treatmentsummary', [treatmentSummary::class, 'treatmentSummary'])
        ->name('treatmentSummary');

    // Version 5 Report Routes
    Route::get('/detail-ra5', [detailRA_5::class, 'detailRA_5'])
        ->name('detailRA_5');
    Route::get('/summary5', [summary_5::class, 'summary_5'])
        ->name('summary_5');
    Route::get('/highRecommend5', [highRecommend_5::class, 'highRecommend_5'])
        ->name('highRecommend_5');
    Route::get('/treatmentAppendix5', [treatmentAppendix_5::class, 'treatmentAppendix_5'])
        ->name('treatmentAppendix_5');
    Route::get('/treatmentsummary5', [treatmentsummary_5::class, 'treatmentsummary_5'])
        ->name('treatmentsummary_5');
});

// Bulk Routes
Route::prefix('bulk')->group(function () {
    Route::screen('/valuation', ValuationBulk::class)
        ->name('platform.bulk.valuation');
    Route::screen('/threat', ThreatBulk::class)
        ->name('platform.bulk.threat');
    Route::screen('/vulnerable', VulnerableBulk::class)
        ->name('platform.bulk.vulnerable');
    Route::screen('/safeguard', SafeguardBulk::class)
        ->name('platform.bulk.safeguard');
    Route::screen('/impact', ImpactBulk::class)
        ->name('platform.bulk.impact');
    Route::screen('/riskCalculation', RiskCalculationBulk::class)
        ->name('platform.bulk.riskCalculation');
    Route::screen('/protection', ProtectionBulk::class)
        ->name('platform.bulk.protection');
    Route::screen('/treatment', TreatmentBulk::class)
        ->name('platform.bulk.treatment');
    
});

// Organization Profile
Route::screen('/orgprofile', OrgProfile::class)
    ->name('platform.organizational.profile');

// API Routes
Route::post('/api/threat-details', [Threat::class, 'getThreatDetails']);

use Illuminate\Support\Facades\Log;

Route::get('/users', function() {
    Log::info('Users route accessed');
});
