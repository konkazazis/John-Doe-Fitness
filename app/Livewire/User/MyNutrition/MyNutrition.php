<?php

namespace App\Livewire\User\MyNutrition;

use Livewire\Component;

class MyNutrition extends Component
{
    public function render()
    {
        return view('livewire.user.my-nutrition.my-nutrition')->layout('layouts.app', ['title' => 'My Nutrition — CMS']);
    }
}
