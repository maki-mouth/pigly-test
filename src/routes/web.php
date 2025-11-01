<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeightLogController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/register/step1', [WeightLogController::class, 'register1'])->name('register1');
Route::get('/register/step2', [WeightLogController::class, 'register2'])->name('register2');
Route::get('/login', [WeightLogController::class, 'login'])->name('login');
Route::get('/weight_logs', [WeightLogController::class, 'log'])->name('log');
Route::get('/weight_logs/goal_setting', [WeightLogController::class, 'target'])->name('target');
Route::get('/weight_logs/{weightLogId}', [WeightLogController::class, 'detail'])->name('detail');
