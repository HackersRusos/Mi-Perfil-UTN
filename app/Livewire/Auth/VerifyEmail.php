<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use App\Livewire\Actions\Logout;

class VerifyEmail extends Component
{
    public function sendVerification(): void
    {
        if (Auth::user()->hasVerifiedEmail()) {
            redirect()->intended(route('dashboard'));
        }

        Auth::user()->sendEmailVerificationNotification();
        Session::flash('status', 'verification-link-sent');
    }

    public function logout(Logout $logout): void
    {
        $logout();
        Session::invalidate();
        Session::regenerateToken();

        redirect('/');
    }

    public function render()
    {
        return view('livewire.auth.verify-email')->layout('components.layouts.auth');
    }
}
