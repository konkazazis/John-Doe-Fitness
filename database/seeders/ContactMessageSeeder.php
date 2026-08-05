<?php

namespace Database\Seeders;

use App\Models\ContactMessage;
use Illuminate\Database\Seeder;

class ContactMessageSeeder extends Seeder
{
    public function run(): void
    {
        $messages = [
            [
                'name' => 'Ethan Brooks',
                'email' => 'ethan.brooks@example.com',
                'subject' => 'Online coaching availability',
                'message' => "Hi, I'm interested in online coaching. Do you have any spots open for new clients this month?",
                'is_read' => true,
                'days_ago' => 9,
            ],
            [
                'name' => 'Priya Nair',
                'email' => 'priya.nair@example.com',
                'subject' => 'Question about the Pro plan',
                'message' => "Does the Pro plan include a custom meal plan, or is that a separate add-on?",
                'is_read' => true,
                'days_ago' => 5,
            ],
            [
                'name' => 'Marcus Lee',
                'email' => 'marcus.lee@example.com',
                'subject' => null,
                'message' => "Loved the blog post on mobility work. Do you offer in-person sessions as well?",
                'is_read' => false,
                'days_ago' => 2,
            ],
            [
                'name' => 'Olivia Bennett',
                'email' => 'olivia.bennett@example.com',
                'subject' => 'Partnership inquiry',
                'message' => "I run a local running club and would love to talk about a potential collaboration.",
                'is_read' => false,
                'days_ago' => 1,
            ],
        ];

        foreach ($messages as $data) {
            ContactMessage::firstOrCreate(
                ['email' => $data['email'], 'message' => $data['message']],
                [
                    'name' => $data['name'],
                    'subject' => $data['subject'],
                    'is_read' => $data['is_read'],
                    'created_at' => now()->subDays($data['days_ago']),
                    'updated_at' => now()->subDays($data['days_ago']),
                ]
            );
        }
    }
}
