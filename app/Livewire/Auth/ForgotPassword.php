<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Password;
use Livewire\Component;

class ForgotPassword extends Component
{
    public $email = '';

    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        Password::sendResetLink(['email' => $this->email]);

        session()->flash('status', __('A reset link will be sent if the account exists.'));
    }

    public function render()
    {
        return view('livewire.auth.forgot-password')->layout('components.layouts.auth');
    }
}
