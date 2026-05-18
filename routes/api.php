<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Secure\UserController as SecureUserController;
use App\Http\Controllers\admin\AuthController as adminAuthController;


Route::prefix('secure')->group(function () {
    Route::post('/check-user-mail', [SecureUserController::class, 'checkMail']);
    Route::post('/check-user-mobile', [SecureUserController::class, 'checkMobile']);
});

Route::post('/admin/login', [adminAuthController::class, 'authenticateApi'])
    ->middleware('web')
    ->name('api.admin.login');
