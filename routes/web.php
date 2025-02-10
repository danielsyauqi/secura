<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route(config('platform.index'));
});
 






