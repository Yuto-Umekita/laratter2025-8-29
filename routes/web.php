<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TweetController;
use App\Http\Controllers\TweetLikeController; // ← 追加
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ▼ ゲストも閲覧可（一覧/詳細）
Route::resource('tweets', TweetController::class)->only(['index', 'show']);

Route::middleware('auth')->group(function () {
    // プロフィール
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ▼ 投稿系（作成/保存/編集/更新/削除）はログイン必須
    Route::resource('tweets', TweetController::class)->except(['index', 'show']);

    // ▼ いいね系
    Route::post('/tweets/{tweet}/like', [TweetLikeController::class, 'store'])->name('tweets.like');
    Route::delete('/tweets/{tweet}/like', [TweetLikeController::class, 'destroy'])->name('tweets.dislike');
});

require __DIR__ . '/auth.php';
