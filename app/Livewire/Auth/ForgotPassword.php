<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Password;
use Livewire\Component;
use Illuminate\Validation\ValidationException;

class ForgotPassword extends Component
{
    public $email = '';

    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ]);
    
        $status = Password::sendResetLink([
            'email' => $this->email,
        ]);
    
        if ($status === Password::RESET_LINK_SENT) {
            session()->flash('status', __($status));
             // 🔹 Redirige al login después de enviar correctamente
             $this->redirectRoute('login', navigate: true);
        } else {
            $this->addError('email', __($status));
        }
    }

    public function render()
    {
        return view('livewire.auth.forgot-password')->layout('components.layouts.auth');
    }
}
