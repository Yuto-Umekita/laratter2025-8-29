<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TweetController;
use App\Http\Controllers\TweetLikeController; // �� �ǉ�
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// �� �Q�X�g���{���i�ꗗ/�ڍׁj
Route::resource('tweets', TweetController::class)->only(['index', 'show']);

Route::middleware('auth')->group(function () {
    // �v���t�B�[��
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // �� ���e�n�i�쐬/�ۑ�/�ҏW/�X�V/�폜�j�̓��O�C���K�{
    Route::resource('tweets', TweetController::class)->except(['index', 'show']);

    // �� �����ˌn
    Route::post('/tweets/{tweet}/like', [TweetLikeController::class, 'store'])->name('tweets.like');
    Route::delete('/tweets/{tweet}/like', [TweetLikeController::class, 'destroy'])->name('tweets.dislike');
});

require __DIR__ . '/auth.php';
