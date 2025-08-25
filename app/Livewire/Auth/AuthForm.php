<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Events\Registered;
use App\Models\User;
use App\Models\Profile;

class AuthForm extends Component
{
    /** UI */
    public bool $isLogin = true;
    public bool $showPassword = false;
    public bool $showPasswordConfirm = false;
    public bool $remember = false;

    /** Campos login */
    public string $email = '';
    public string $password = '';

    /** Campos registro */
    public string $first_name = '';
    public string $last_name  = '';
    public string $password_confirmation = '';

    /** Permite fijar el modo por query (?mode=login|register) */
    public function mount(?string $mode = null): void
    {
        if ($mode === 'register') $this->isLogin = false;
        if ($mode === 'login')    $this->isLogin = true;
    }

    /** Switch de pestañas */
    public function showLogin(): void    { $this->isLogin = true; }
    public function showRegister(): void { $this->isLogin = false; }

    public function togglePassword(): void        { $this->showPassword = ! $this->showPassword; }
    public function togglePasswordConfirm(): void { $this->showPasswordConfirm = ! $this->showPasswordConfirm; }

    private function redirectToRoleDashboard($user)
    {
        if ($user->hasAnyRole('admin','3')) {
            return route('admin.dashboard');
        }
    
        if ($user->hasAnyRole('profesor','2')) {
            return route('profesor.dashboard');
        }
    
        if ($user->hasAnyRole('estudiante','1')) {
            // ✅ Redirige a su propio perfil con el dni
            return route('estudiantes.show', $user->profile->dni);
        }
    
        return route('home');
    }

    /** ---- LOGIN ---- */
    public function login(): void
    {
        $this->validate([
            'email'    => ['required','email'],
            'password' => ['required'],
        ]);
    
        $this->ensureIsNotRateLimited();
    
        if (! Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            RateLimiter::hit($this->throttleKey());
            throw ValidationException::withMessages(['email' => __('auth.failed')]);
        }
    
        RateLimiter::clear($this->throttleKey());
        Session::regenerate();
    
        $u = Auth::user();
        $to = $this->redirectToRoleDashboard($u);
    
        $this->redirect($to, navigate: false);
    }


    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) return;

        $seconds = RateLimiter::availableIn($this->throttleKey());
        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    protected function throttleKey(): string
    {
        return strtolower($this->email).'|'.request()->ip();
    }

    /** ---- REGISTRO ---- */
    public function register(): void
    {
        $validated = $this->validate([
            'first_name'            => ['required','string','max:255'],
            'last_name'             => ['required','string','max:255'],
            'email'                 => ['required','string','lowercase','email','max:255','unique:users,email'],
            'password'              => ['required','string', PasswordRule::defaults(), 'confirmed'],
            'password_confirmation' => ['required','string'],
        ]);
    
        $name = trim($validated['first_name'].' '.$validated['last_name']);
    
        $user = User::create([
            'name'     => $name,
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role_id'  => 1, // estudiante por defecto
        ]);
    
        Profile::create([
            'user_id'   => $user->id,
            'nombre'    => $validated['first_name'],
            'apellido'  => $validated['last_name'],
            'telefono'  => '',
            'dni'       => 'TMP-'.$user->id,
            'comision'  => null,
            'carrera'   => null,
            'foto_path' => null,
            'social_links' => null,
        ]);
    
        event(new Registered($user));
        Auth::login($user);
    
        $to = $this->redirectToRoleDashboard($user);
    
        $this->redirect($to, navigate: false);
    }


    public function render()
    {
        return view('livewire.auth.auth-form')
            ->layout('components.layouts.auth'); // o el layout que uses para auth
    }
}
