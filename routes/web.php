<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InstanceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WebsiteController;

// Website Routes
Route::get('/', [WebsiteController::class, 'home'])->name('website.home');
Route::get('/features', [WebsiteController::class, 'features'])->name('website.features');
Route::get('/download', [WebsiteController::class, 'download'])->name('website.download');
Route::get('/host', [WebsiteController::class, 'host'])->name('website.host');

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::get('register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('register', [AuthController::class, 'register']);

    Route::get('forgot-password', [PasswordResetController::class, 'showForgotPassword'])
        ->name('password.request');
    Route::post('forgot-password', [PasswordResetController::class, 'sendResetLink'])
        ->name('password.email');
    Route::get('reset-password/{token}', [PasswordResetController::class, 'showResetPassword'])
        ->name('password.reset');
    Route::post('reset-password', [PasswordResetController::class, 'resetPassword'])
        ->name('password.update');
});

// Auth routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Instance routes
    Route::resource('instances', InstanceController::class);
    Route::post('/instances/{instance}/verify-dns', [InstanceController::class, 'verifyDns'])->name('instances.verify-dns');
    Route::post('/instances/{instance}/toggle-beta', [InstanceController::class, 'toggleBeta'])->name('instances.toggle-beta');
    Route::post('/instances/{instance}/mark-api-tokens-set', [InstanceController::class, 'markApiTokensAsSet'])
        ->name('instances.mark-api-tokens-set');
    Route::put('/instances/{instance}/minecraft-config', [InstanceController::class, 'updateMinecraftConfig'])
        ->name('instances.update-minecraft-config');
    Route::put('/instances/{instance}/hostname', [InstanceController::class, 'updateHostname'])
        ->name('instances.update-hostname');
    Route::post('/instances/{instance}/convert-trial', [InstanceController::class, 'convertTrial'])
        ->name('instances.convert-trial');
});
