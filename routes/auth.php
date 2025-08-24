<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Livewire\Auth\AuthForm as AuthForm;

// ⛔ Nada de Volt acá.

Route::middleware('guest')->group(function () {
    Route::get('/auth', AuthForm::class)->name('auth'); // /auth?mode=login o /auth?mode=register
    Route::get('forgot-password', \App\Livewire\Auth\ForgotPassword::class)->name('password.request');
    Route::get('reset-password/{token}', \App\Livewire\Auth\ResetPassword::class)->name('password.reset');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', \App\Livewire\Auth\VerifyEmail::class)->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::get('confirm-password', \App\Livewire\Auth\ConfirmPassword::class)->name('password.confirm');
});

// Logout (si ya lo tenés así, dejalo)
Route::post('logout', \App\Livewire\Actions\Logout::class)->name('logout');
