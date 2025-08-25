<?php

namespace App\Livewire\Estudiante;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Gate;
use App\Models\Profile;

class Dashboard extends Component
{
    use WithFileUploads;

    public bool $editing = false;

    public $nombre, $apellido, $dni, $telefono, $carrera, $comision;
    public $instagram, $facebook, $linkedin, $web;
    public $email;
    public $foto;
    public ?Profile $profile = null;

    /**
     * Si viene un profileId → carga ese perfil
     * Si no → carga el perfil del usuario autenticado
     */
    public function mount(Profile $profile)
    {
        Gate::authorize('view', $profile);
    
        $this->profile = $profile;
        $this->email   = $profile->user->email;
    
        $this->nombre   = $profile->nombre   ?? null;
        $this->apellido = $profile->apellido ?? null;
        $this->dni      = $profile->dni      ?? null;
        $this->telefono = $profile->telefono ?? null;
        $this->carrera  = $profile->carrera  ?? null;
        $this->comision = $profile->comision ?? null;
    
        $links = $profile->social_links ?? [];
        $this->instagram = $links['instagram'] ?? null;
        $this->facebook  = $links['facebook']  ?? null;
        $this->linkedin  = $links['linkedin']  ?? null;
        $this->web       = $links['web']       ?? null;
    }




    public function rules()
    {
        $id = $this->profile?->id ?? 'NULL';

        return [
            'nombre'   => ['required','string','max:100'],
            'apellido' => ['required','string','max:100'],
            'dni'      => ['nullable','string','max:20','unique:profiles,dni,'.$id],
            'telefono' => ['nullable','string','max:30'],
            'carrera'  => ['nullable','string','max:120'],
            'comision' => ['nullable','string','max:50'],
            'instagram'=> ['nullable','url'],
            'facebook' => ['nullable','url'],
            'linkedin' => ['nullable','url'],
            'web'      => ['nullable','url'],
            'foto'     => ['nullable','image','max:2048'],
        ];
    }

    public function startEditing()
    {
        Gate::authorize('update', $this->profile);
        $this->editing = true;
    }

    public function updatingEditing($value)
    {
        if ($value && Gate::denies('update', $this->profile)) {
            $this->editing = false;
        }
    }

    public function save()
    {
        Gate::authorize('update', $this->profile);
        $this->validate();

        $user = auth()->user();
        $path = $this->profile?->foto_path;

        if ($this->foto) {
            $path = $this->foto->store('profiles', 'public');
        }

        $this->profile = Profile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'nombre'      => $this->nombre,
                'apellido'    => $this->apellido,
                'dni'         => $this->dni,
                'telefono'    => $this->telefono,
                'carrera'     => $this->carrera ?: null,
                'comision'    => $this->comision ?: null,
                'foto_path'   => $path,
                'social_links'=> array_filter([
                    'instagram' => $this->instagram,
                    'facebook'  => $this->facebook,
                    'linkedin'  => $this->linkedin,
                    'web'       => $this->web,
                ]),
            ]
        );

        $this->editing = false;
        session()->flash('success', 'Perfil actualizado con éxito.');
    }

    public function whatsappUrl(): ?string
    {
        $digits = preg_replace('/\D+/', '', (string) $this->telefono);
        if (!$digits) return null;
        if (str_starts_with($digits, '0')) $digits = ltrim($digits, '0');
        if (!str_starts_with($digits, '54')) $digits = '54'.$digits;

        return "https://wa.me/{$digits}";
    }

    public function render()
    {
        return view('livewire.estudiante.dashboard', [
            'profile' => $this->profile,
        ])->layout('components.layouts.app');
    }
}
