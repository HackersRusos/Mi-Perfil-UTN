<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Livewire\Auth\Register;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Rutas Livewire Volt
Volt::route('register', 'auth.register');          // Registro
Volt::route('login', 'auth.login');                // Login agregado

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});
Volt::route('profesor', 'profesor.dashboard')   // URL: /profesor
    ->middleware(['auth','verified'])           // por ahora solo auth/verified
    ->name('profesor.dashboard');


require __DIR__.'/auth.php';
