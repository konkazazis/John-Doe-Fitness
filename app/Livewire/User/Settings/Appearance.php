<?php

namespace App\Livewire\User\Settings;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Appearance settings')]
class Appearance extends Component
{
    public function render()
    {
        return view('livewire.user.settings.appearance')
            ->layout('layouts.app', ['title' => 'Appearance']);
    }
}
