<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AuthController as adminAuthController;
use App\Http\Controllers\admin\DashboardController as adminDashboardController;
use App\Http\Controllers\admin\LogoutController as adminLogoutController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->group(function () {
    Route::middleware('is_guest_admin')->group(function () {
        Route::get('/login', [adminAuthController::class, 'showLoginForm'])->name('admin.login');
        Route::get('/register', [adminAuthController::class, 'showRegisterForm'])->name('admin.register');        
        Route::post('/auth', [adminAuthController::class, 'authenticate'])->name('admin.auth');
        Route::get('/forget-password', [adminAuthController::class, 'showForgetPasswordForm'])->name('admin.forget-password');
        Route::post('/reset-password', [adminAuthController::class, 'resetPassword'])->name('admin.reset-password');
        Route::post('/change-password', [adminAuthController::class, 'changePassword'])->name('admin.change-password');
    });
    
    Route::middleware('is_admin_logged')->group(function () {
        Route::get('/', [adminDashboardController::class, 'showDashboard']);
        Route::get('/dashboard', [adminDashboardController::class, 'showDashboard'])->name('admin.dashboard');
        Route::get('/log-out', [adminLogoutController::class, 'logout'])->name('admin.logout');
    });
});