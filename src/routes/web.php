<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeightLogController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/register/step2', [WeightLogController::class, 'register2']);
