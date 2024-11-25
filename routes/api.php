<?php

// In routes/api.php
use Illuminate\Support\Facades\Route;
use App\Orchid\Screens\Assessment\Threat;

Route::post('/api/threat-details', [Threat::class, 'getThreatDetails']);
