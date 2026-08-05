<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            [
                'client' => 'Alex Carter',
                'quote' => 'I finally understand how to train and eat for my goals — no more guessing.',
                'description' => 'Alex worked through a 12-week recomposition program with weekly check-ins.',
            ],
            [
                'client' => 'Maria Gomez',
                'quote' => 'Went from couch to marathon finisher. The coaching made it feel achievable.',
                'description' => 'Maria followed a progressive running plan built around her work schedule.',
            ],
            [
                'client' => 'Liam Chen',
                'quote' => 'My lifts have never moved this fast. The programming just works.',
                'description' => 'Liam focused on a strength-first program with structured progressive overload.',
            ],
            [
                'client' => 'Sophie Turner',
                'quote' => 'I felt supported every step of getting back into training safely.',
                'description' => 'Sophie returned to training postpartum with a carefully paced program.',
            ],
            [
                'client' => 'James Whitfield',
                'quote' => 'Clear plans, honest feedback, and real results. Highly recommend.',
                'description' => 'James used a hybrid strength and conditioning plan over four months.',
            ],
        ];

        foreach ($testimonials as $order => $data) {
            Testimonial::firstOrCreate(
                ['client' => $data['client'], 'quote' => $data['quote']],
                [
                    'description' => $data['description'],
                    'order' => $order,
                    'is_published' => true,
                ]
            );
        }
    }
}
