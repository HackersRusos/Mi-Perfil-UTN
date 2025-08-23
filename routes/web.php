<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Models\Profile;

// Página de inicio
Route::get('/', function () {
    return view('welcome');
})->name('home');

// 🔐 Autenticación (Volt)
Volt::route('register', 'auth.register')->middleware('guest')->name('register');
Volt::route('login', 'auth.login')->middleware('guest')->name('login');

// ⚙️ Configuración (solo usuarios autenticados)
Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

// 🛡️ Admin (ruta creada; vista/volt se hará luego)
Volt::route('admin/dashboard', 'admin.dashboard')
    ->middleware(['auth', 'role:admin'])
    ->name('admin.dashboard');

// 👨‍🏫 Dashboard Profesor
Volt::route('profesor', 'profesor.dashboard')
    ->middleware(['auth', 'role:profesor'])
    ->name('profesor.dashboard');

// 🎓 Dashboard Estudiante (su propio perfil)
Volt::route('dashboard', 'estudiante.dashboard')
    ->middleware(['auth', 'role:estudiante'])
    ->name('dashboard');

// 👀 Ver perfil de estudiante (solo admin/profesor)
Volt::route('estudiantes/{profile}', 'estudiante.dashboard')
    ->middleware(['auth', 'can:view,profile'])
    ->name('estudiantes.show');

require __DIR__ . '/auth.php';
