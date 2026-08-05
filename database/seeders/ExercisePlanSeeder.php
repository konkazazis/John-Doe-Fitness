<?php

namespace Database\Seeders;

use App\Models\ExercisePlan;
use App\Models\User;
use Illuminate\Database\Seeder;

class ExercisePlanSeeder extends Seeder
{
    public function run(): void
    {
        $alex = User::where('email', 'alex.carter@example.com')->first();
        $liam = User::where('email', 'liam.chen@example.com')->first();

        if ($alex) {
            $active = ExercisePlan::firstOrCreate(
                ['user_id' => $alex->id, 'title' => 'Upper/Lower Split - Month 3'],
                [
                    'goal' => 'Lean muscle gain',
                    'notes' => 'Rest 90 seconds between sets. Increase load once all reps are completed with good form.',
                    'is_active' => true,
                ]
            );

            if ($active->exercises()->count() === 0) {
                $exercises = [
                    ['name' => 'Bench press', 'description' => '3-1-1 tempo', 'sets' => 4, 'reps' => 8, 'weight' => '70kg'],
                    ['name' => 'Barbell row', 'sets' => 4, 'reps' => 10, 'weight' => '60kg'],
                    ['name' => 'Overhead press', 'sets' => 3, 'reps' => 10, 'weight' => '40kg'],
                    ['name' => 'Lat pulldown', 'sets' => 3, 'reps' => 12, 'weight' => '55kg'],
                ];
                foreach ($exercises as $order => $exercise) {
                    $active->exercises()->create($exercise + ['order' => $order]);
                }
            }
        }

        if ($liam) {
            $active = ExercisePlan::firstOrCreate(
                ['user_id' => $liam->id, 'title' => 'Strength Block - Phase 2'],
                [
                    'goal' => 'Build maximal strength',
                    'notes' => 'Focus on bar speed for the main lifts. Deload in week 4.',
                    'is_active' => true,
                ]
            );

            if ($active->exercises()->count() === 0) {
                $exercises = [
                    ['name' => 'Back squat', 'description' => '5x5 at 80% 1RM', 'sets' => 5, 'reps' => 5, 'weight' => '120kg'],
                    ['name' => 'Deadlift', 'sets' => 3, 'reps' => 5, 'weight' => '150kg'],
                    ['name' => 'Incline bench press', 'sets' => 4, 'reps' => 6, 'weight' => '65kg'],
                ];
                foreach ($exercises as $order => $exercise) {
                    $active->exercises()->create($exercise + ['order' => $order]);
                }
            }
        }
    }
}
