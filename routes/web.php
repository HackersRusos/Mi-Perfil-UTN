<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Estudiante\Dashboard as EstudianteDashboard;
use App\Livewire\Profesor\Dashboard as ProfesorDashboard;
use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\Auth\AuthForm;
use App\Livewire\Auth\ConfirmPassword;
use App\Livewire\Auth\ForgotPassword;
use App\Livewire\Auth\ResetPassword;
use App\Livewire\Auth\VerifyEmail;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Appearance;

// Página de inicio
Route::get('/', function () {
    return view('welcome');
})->name('home');

// 🔐 Autenticación
Route::get('/auth', AuthForm::class)->name('auth');
Route::get('/login', AuthForm::class)->name('login');       // alias
Route::get('/register', AuthForm::class)->name('register'); // alias

Route::get('/confirm-password', ConfirmPassword::class)
    ->middleware(['auth'])
    ->name('password.confirm');

Route::get('/forgot-password', ForgotPassword::class)
    ->middleware('guest')
    ->name('password.request');

Route::get('/reset-password/{token}', ResetPassword::class)
    ->middleware('guest')
    ->name('password.reset');

Route::get('/verify-email', VerifyEmail::class)
    ->middleware(['auth'])
    ->name('verification.notice');

// ⚙️ Configuración (solo autenticados)
Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

// 🛡️ Admin
Route::get('/admin', AdminDashboard::class)
    ->middleware(['auth', 'role:admin'])
    ->name('admin.dashboard');

// 👨‍🏫 Profesor
Route::get('/profesor', ProfesorDashboard::class)
    ->middleware(['auth', 'role:profesor'])
    ->name('profesor.dashboard');

// 🎓 Estudiante
Route::get('/estudiante', EstudianteDashboard::class)
    ->middleware(['auth', 'role:estudiante'])
    ->name('estudiante.dashboard');

// 👀 Ver perfil de estudiante
Route::get('/estudiantes/{profile}', EstudianteDashboard::class)
    ->middleware(['auth', 'can:view,profile'])
    ->name('estudiantes.show');

// 🔓 Logout (POST recomendado)
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('home');
})->name('logout');

require __DIR__ . '/auth.php';
