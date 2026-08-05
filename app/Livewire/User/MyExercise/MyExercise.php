<?php

namespace App\Livewire\User\MyExercise;

use App\Models\ExercisePlan;
use Livewire\Component;

class MyExercise extends Component
{
    public function render()
    {
        $activePlan = ExercisePlan::with('exercises')
            ->where('user_id', auth()->id())
            ->where('is_active', true)
            ->first();

        $pastPlans = ExercisePlan::where('user_id', auth()->id())
            ->where('is_active', false)
            ->latest()
            ->get();

        return view('livewire.user.my-exercise.my-exercise', compact('activePlan', 'pastPlans'))
            ->layout('layouts.app', ['title' => 'My Exercise']);
    }
}
