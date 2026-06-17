<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AkunGameController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TopupController;

// Public Routes
Route::get('/', [AkunGameController::class, 'index'])->name('home');

// Guest Routes (Only accessible when not logged in)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::get('/jualakun', [AkunGameController::class, 'create'])->name('jualakun');
    Route::post('/jualakun', [AkunGameController::class, 'store'])->name('jualakun.store');
    Route::post('/jualakun/{id_akun}/terjual', [AkunGameController::class, 'markAsSold'])->name('jualakun.terjual');
    Route::get('/edit-akun/{id_akun}', [AkunGameController::class, 'edit'])->name('jualakun.edit');
    Route::put('/edit-akun/{id_akun}', [AkunGameController::class, 'update'])->name('jualakun.update');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/my-posts', [ProfileController::class, 'myPosts'])->name('myposts');
    Route::get('/my-games', [ProfileController::class, 'myGames'])->name('mygames');

    Route::get('/checkout/{id_akun}', [AkunGameController::class, 'checkout'])->name('checkout');
    Route::post('/checkout/{id_akun}', [AkunGameController::class, 'processCheckout'])->name('checkout.process');

    Route::get('/topup', [TopupController::class, 'index'])->name('topup');
    Route::post('/topup', [TopupController::class, 'process'])->name('topup.process');
});
