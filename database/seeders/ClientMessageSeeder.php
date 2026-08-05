<?php

namespace Database\Seeders;

use App\Models\ClientMessage;
use App\Models\User;
use Illuminate\Database\Seeder;

class ClientMessageSeeder extends Seeder
{
    public function run(): void
    {
        $conversations = [
            'alex.carter@example.com' => [
                ['sender' => 'user', 'message' => "Hey! Quick question — should I be increasing weight on squats every session?", 'minutes_ago' => 4320, 'is_read' => true],
                ['sender' => 'admin', 'message' => "Not every session — aim to add weight once you can hit all reps with good form for two sessions in a row.", 'minutes_ago' => 4200, 'is_read' => true],
                ['sender' => 'user', 'message' => "That makes sense, thanks! I'll track it that way going forward.", 'minutes_ago' => 60, 'is_read' => false],
            ],
            'maria.gomez@example.com' => [
                ['sender' => 'user', 'message' => "My knee has been a bit sore after long runs. Should I scale back this week?", 'minutes_ago' => 1440, 'is_read' => true],
                ['sender' => 'admin', 'message' => "Yes, let's drop your long run by 20% this week and add some extra mobility work. Let me know how it feels.", 'minutes_ago' => 1380, 'is_read' => false],
            ],
        ];

        foreach ($conversations as $email => $messages) {
            $client = User::where('email', $email)->first();

            if (! $client) {
                continue;
            }

            foreach ($messages as $data) {
                ClientMessage::firstOrCreate(
                    ['user_id' => $client->id, 'message' => $data['message']],
                    [
                        'sender' => $data['sender'],
                        'is_read' => $data['is_read'],
                        'created_at' => now()->subMinutes($data['minutes_ago']),
                        'updated_at' => now()->subMinutes($data['minutes_ago']),
                    ]
                );
            }
        }
    }
}
