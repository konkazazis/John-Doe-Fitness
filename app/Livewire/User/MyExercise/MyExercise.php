<?php

namespace App\Livewire\User\MyExercise;

use Livewire\Component;

class MyExercise extends Component
{
    public function render()
    {
        return view('livewire.user.my-exercise.my-exercise')->layout('layouts.app', ['title' => 'My Exercise — CMS']);
    }
}
