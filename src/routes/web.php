<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeightLogController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TargetController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/register/step1', [RegisterController::class, 'showRegister1'])->name('register1');
    Route::post('/register/step1', [RegisterController::class, 'processRegister1'])->name('register1.post');
    Route::get('/register/step2', [RegisterController::class, 'showRegister2'])->name('register2');
    Route::post('/register/step2', [RegisterController::class, 'processRegister2'])->name('register2.post');
});

Route::middleware('auth')->group(function () {
    Route::get('/weight_logs', [WeightLogController::class, 'log'])->name('log');
    Route::post('/weight_logs/create', [WeightLogController::class, 'store'])->name('store');
    Route::get('/weight_logs/goal_setting', [TargetController::class, 'edit'])->name('target');
    Route::put('/weight_logs/goal_setting', [TargetController::class, 'update'])->name('target.update');
    Route::get('/weight_logs/{weightLogId}', [WeightLogController::class, 'detail'])->name('detail');
    Route::put('/weight_logs/{weightLogId}/update', [WeightLogController::class, 'update'])->name('update');
    Route::delete('/weight_logs/{weightLogId}/delete', [WeightLogController::class, 'destroy'])->name('destroy');

    // ログアウト処理の明示的な定義 ★★★
    Route::post('/logout', function (Request $request) {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    })->name('logout');
});


// Fortifyのビューバインド問題を回避するためのルート上書き (GET /login)
Route::get('/login', function () {
    return view('login');
})->name('login');
