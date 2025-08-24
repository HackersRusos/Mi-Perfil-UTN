<?php

namespace App\Livewire\Settings;

use Livewire\Component;

class Appearance extends Component
{
    public string $theme = 'system';

    public function mount(): void
    {
        $this->theme = session('appearance', 'system');
    }

    public function updatedTheme($value): void
    {
        session(['appearance' => $value]);
    }

    public function render()
    {
        return view('livewire.settings.appearance')->layout('components.layouts.app');
    }
}
