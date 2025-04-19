<?php

use App\Http\Controllers\Auth\User\AuthenticatedSessionController;
use App\Http\Controllers\Auth\Owner\OwnerAuthenticatedSessionController;
use App\Http\Controllers\Auth\Admin\AdminAuthenticatedSessionController;
use App\Http\Controllers\Auth\User\ConfirmablePasswordController;
use App\Http\Controllers\Auth\User\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\User\EmailVerificationPromptController;
use App\Http\Controllers\Auth\User\NewPasswordController;
use App\Http\Controllers\Auth\User\PasswordResetLinkController;
use App\Http\Controllers\Auth\User\RegisteredUserController;
use App\Http\Controllers\Auth\Owner\OwnerEmailVerificationNotificationController;
use App\Http\Controllers\Auth\Owner\OwnerEmailVerificationPromptController;
use App\Http\Controllers\Auth\Owner\OwnerVerifyEmailController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\Auth\User\VerifyEmailController;

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');
    Route::get('owner/login', [OwnerAuthenticatedSessionController::class, 'ownerCreate'])
        ->name('owner.login');
    Route::get('admin/login', [AdminAuthenticatedSessionController::class, 'adminCreate'])
        ->name('admin.login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);
    Route::post('owner/login', [OwnerAuthenticatedSessionController::class, 'ownerStore']);
    Route::post('admin/login', [AdminAuthenticatedSessionController::class, 'adminStore']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.update');
});

Route::middleware('auth:web')->group(function () {
    Route::get('verify-email', [EmailVerificationPromptController::class, '__invoke'])
        ->name('verification.notice');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});

Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
    ->middleware(['auth:web', 'signed', 'throttle:6,1'])
    ->name('verification.verify');

Route::get('owner/verify-email/{id}/{hash}', [OwnerVerifyEmailController::class, '__invoke'])
    ->middleware(['signed', 'throttle:6,1'])
    ->name('owner.verification.verify');

Route::middleware('auth:owner')->group(function () {
    Route::post('owner/logout', [OwnerAuthenticatedSessionController::class, 'ownerDestroy'])
        ->name('owner.logout');
});

Route::middleware('auth:admin')->group(function () {
    Route::post('admin/logout', [AdminAuthenticatedSessionController::class, 'adminDestroy'])
        ->name('admin.logout');
    Route::post('admin/mypage', [AdminController::class, 'storeOwner']);
});
