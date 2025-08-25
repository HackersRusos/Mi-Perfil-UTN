<?php

namespace App\Livewire\Profesor;

use Livewire\Component;
use App\Models\Profile;

class Dashboard extends Component
{
    public function render()
    {
        // Solo perfiles de estudiantes (role_id = 1)
        $profiles = Profile::with('user')
            ->whereHas('user', fn($q) => $q->where('role_id', 1))
            ->orderBy('apellido')
            ->get();

        return view('livewire.profesor.dashboard', [
            'profiles' => $profiles,
        ])->layout('components.layouts.app');
    }
}
