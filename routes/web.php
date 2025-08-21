<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Models\Profile;

// Página de inicio
Route::get('/', function () {
    return view('welcome');
})->name('home');

// 🔐 Autenticación básica (Volt)
Volt::route('register', 'auth.register')->name('register');
Volt::route('login', 'auth.login')->name('login');

// ⚙️ Configuración (solo usuarios logueados)
Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

// 👨‍🏫 Dashboard Profesor
Volt::route('profesor', 'profesor.dashboard')
    ->middleware(['auth', 'verified'])
    ->name('profesor.dashboard');

// 🎓 Dashboard Estudiante (su propio perfil)
Volt::route('dashboard', 'estudiante.dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// 👀 Vista de perfil de un estudiante (para profesores u otros)
Volt::route('/estudiantes/{profile}', 'estudiante.dashboard')
    ->middleware(['auth','verified'])
    ->name('estudiantes.show');

require __DIR__.'/auth.php';
