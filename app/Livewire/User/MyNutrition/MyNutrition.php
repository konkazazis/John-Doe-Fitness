<?php

namespace App\Livewire\User\MyNutrition;

use App\Models\NutritionPlan;
use Livewire\Component;

class MyNutrition extends Component
{
    public function render()
    {
        $activePlan = NutritionPlan::with('meals')
            ->where('user_id', auth()->id())
            ->where('is_active', true)
            ->first();

        $pastPlans = NutritionPlan::where('user_id', auth()->id())
            ->where('is_active', false)
            ->latest()
            ->get();

        return view('livewire.user.my-nutrition.my-nutrition', compact('activePlan', 'pastPlans'))
            ->layout('layouts.app', ['title' => 'My Nutrition']);
    }
}
