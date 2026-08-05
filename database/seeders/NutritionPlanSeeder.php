<?php

namespace Database\Seeders;

use App\Models\NutritionPlan;
use App\Models\User;
use Illuminate\Database\Seeder;

class NutritionPlanSeeder extends Seeder
{
    public function run(): void
    {
        $alex = User::where('email', 'alex.carter@example.com')->first();
        $maria = User::where('email', 'maria.gomez@example.com')->first();

        if ($alex) {
            $active = NutritionPlan::firstOrCreate(
                ['user_id' => $alex->id, 'title' => 'Recomposition Phase - Month 3'],
                [
                    'goal' => 'Lean muscle gain',
                    'daily_calories' => 2200,
                    'protein_grams' => 165,
                    'carbs_grams' => 220,
                    'fat_grams' => 70,
                    'notes' => 'Drink at least 3L of water daily. Weigh in every Monday morning.',
                    'is_active' => true,
                ]
            );

            if ($active->meals()->count() === 0) {
                $meals = [
                    ['name' => 'Breakfast', 'description' => 'Greek yogurt, oats & berries', 'calories' => 420],
                    ['name' => 'Lunch', 'description' => 'Grilled chicken bowl with rice and vegetables', 'calories' => 610],
                    ['name' => 'Snack', 'description' => 'Protein shake & almonds', 'calories' => 310],
                    ['name' => 'Dinner', 'description' => 'Salmon, rice & steamed greens', 'calories' => 600],
                ];
                foreach ($meals as $order => $meal) {
                    $active->meals()->create($meal + ['order' => $order]);
                }
            }

            $past = NutritionPlan::firstOrCreate(
                ['user_id' => $alex->id, 'title' => 'Recomposition Phase - Month 1'],
                [
                    'goal' => 'Lean muscle gain',
                    'daily_calories' => 2000,
                    'protein_grams' => 150,
                    'carbs_grams' => 190,
                    'fat_grams' => 65,
                    'is_active' => false,
                    'created_at' => now()->subMonths(2),
                    'updated_at' => now()->subMonths(2),
                ]
            );
        }

        if ($maria) {
            $active = NutritionPlan::firstOrCreate(
                ['user_id' => $maria->id, 'title' => 'Marathon Fueling Plan'],
                [
                    'goal' => 'Endurance performance',
                    'daily_calories' => 2400,
                    'protein_grams' => 120,
                    'carbs_grams' => 320,
                    'fat_grams' => 70,
                    'notes' => 'Increase carbs on long-run days.',
                    'is_active' => true,
                ]
            );

            if ($active->meals()->count() === 0) {
                $meals = [
                    ['name' => 'Breakfast', 'description' => 'Oatmeal with banana and honey', 'calories' => 450],
                    ['name' => 'Lunch', 'description' => 'Turkey wrap with sweet potato', 'calories' => 650],
                    ['name' => 'Dinner', 'description' => 'Pasta with lean beef and vegetables', 'calories' => 700],
                ];
                foreach ($meals as $order => $meal) {
                    $active->meals()->create($meal + ['order' => $order]);
                }
            }
        }
    }
}
