<?php

namespace App\Livewire\Admin\Settings;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Appearance settings')]
class Appearance extends Component
{
    public function render()
    {
        return view('livewire.admin.settings.appearance')
            ->layout('layouts.app', ['title' => 'Appearance — Settings']);
    }
}
