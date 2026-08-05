<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $projects = [
            [
                'title' => 'Alex — 12-Week Recomposition',
                'description' => 'Lost 8kg of fat while adding visible muscle through a structured strength + nutrition program.',
            ],
            [
                'title' => 'Maria — Marathon Prep',
                'description' => 'Built from zero running base to completing her first marathon in under 4:15.',
            ],
            [
                'title' => 'Liam — Strength From Scratch',
                'description' => 'Doubled his squat, bench and deadlift totals in six months of consistent coaching.',
            ],
            [
                'title' => 'Sophie — Postpartum Return to Fitness',
                'description' => 'A safe, progressive return to training that rebuilt core strength and full-body conditioning.',
            ],
        ];

        foreach ($projects as $order => $data) {
            Project::firstOrCreate(
                ['title' => $data['title']],
                [
                    'description' => $data['description'],
                    'order' => $order,
                    'is_published' => true,
                ]
            );
        }
    }
}
