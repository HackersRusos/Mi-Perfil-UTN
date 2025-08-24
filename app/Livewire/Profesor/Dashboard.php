<?php

namespace App\Livewire\Profesor;

use Livewire\Component;
use App\Models\Profile;

class Dashboard extends Component
{
     public $profiles;

    public function mount()
    {
        $this->profiles = Profile::with('user')->orderBy('apellido')->get();
    }

    public function render()
    {
        return view('livewire.profesor.dashboard', [
            'profiles' => $this->profiles
        ])->layout('components.layouts.app');
    }
}
