<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;

class Dashboard extends Component
{
    public $usuarios;

    public function mount()
    {
        $this->cargarUsuarios();
    }

    public function cargarUsuarios()
    {
        $this->usuarios = User::with('profile')->get();
    }

    public function hacerProfesor($userId)
    {
        $user = User::findOrFail($userId);
        $user->update(['role_id' => 2]); // 2 = Profesor
        $this->cargarUsuarios();
    }

    public function quitarProfesor($userId)
    {
        $user = User::findOrFail($userId);
        $user->update(['role_id' => 1]); // 1 = Estudiante
        $this->cargarUsuarios();
    }

    public function render()
    {
        return view('livewire.admin.dashboard', [
            'totalUsuarios'    => User::count(),
            'totalProfesores'  => User::where('role_id', 2)->count(),
            'totalEstudiantes' => User::where('role_id', 1)->count(),
            'totalAdmins'      => User::where('role_id', 3)->count(),
        ])->layout('components.layouts.app');
    }
}
