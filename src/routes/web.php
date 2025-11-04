<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeightLogController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TargetController;
use Illuminate\Support\Facades\Auth; // ★ Authファサードを追加
use Illuminate\Http\Request; // ★★★ この行を追加 ★★★


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    // ... (自作の2段階登録ルートは維持) ...
    Route::get('/register/step1', [RegisterController::class, 'showRegister1'])->name('register1');
    Route::post('/register/step1', [RegisterController::class, 'processRegister1'])->name('register1.post');
    Route::get('/register/step2', [RegisterController::class, 'showRegister2'])->name('register2');
    Route::post('/register/step2', [RegisterController::class, 'processRegister2'])->name('register2.post');
});

Route::middleware('auth')->group(function () {
    // 体重ログ関連のルート
    Route::get('/weight_logs', [WeightLogController::class, 'log'])->name('log');
    Route::post('/weight_logs/create', [WeightLogController::class, 'store'])->name('store');
    Route::get('/weight_logs/goal_setting', [TargetController::class, 'edit'])->name('target');
    Route::put('/weight_logs/goal_setting', [TargetController::class, 'update'])->name('target.update');
    Route::get('/weight_logs/{weightLogId}', [WeightLogController::class, 'detail'])->name('detail');
    Route::put('/weight_logs/{weightLogId}/update', [WeightLogController::class, 'update'])->name('update');
    Route::delete('/weight_logs/{weightLogId}/delete', [WeightLogController::class, 'destroy'])->name('destroy');

    // ★★★ 追記: ログアウト処理の明示的な定義 ★★★
    Route::post('/logout', function (Request $request) {
        // Fortifyのログアウト処理を模倣
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // ログアウト後のリダイレクト先を設定 (通常はログイン画面へ)
        return redirect('/login'); 
    })->name('logout');
});


// Fortifyのビューバインド問題を回避するためのルート上書き (GET /login)
Route::get('/login', function () {
    return view('login');
})->name('login');

// POST /login はFortifyの処理に任せます。
