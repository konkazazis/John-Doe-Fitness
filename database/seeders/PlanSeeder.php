<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Seed data uses placeholder stripe_price_id values since no real Stripe
     * prices exist yet — replace these in the admin panel before going live.
     */
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Starter',
                'stripe_price_id' => 'price_seed_starter_monthly',
                'price' => 29.00,
                'billing_cycle' => 'month',
                'description' => 'Get started with a personalized training plan and monthly check-ins.',
                'tag' => null,
                'features' => ['Custom exercise plan', 'Monthly check-in', 'Email support'],
            ],
            [
                'name' => 'Pro',
                'stripe_price_id' => 'price_seed_pro_monthly',
                'price' => 79.00,
                'billing_cycle' => 'month',
                'description' => 'Full coaching with nutrition guidance and weekly accountability.',
                'tag' => 'Most popular',
                'features' => ['Custom exercise plan', 'Custom nutrition plan', 'Weekly check-ins', 'Direct messaging with your coach'],
            ],
            [
                'name' => 'Pro Annual',
                'stripe_price_id' => 'price_seed_pro_yearly',
                'price' => 799.00,
                'billing_cycle' => 'year',
                'description' => 'The full Pro experience at a discounted annual rate.',
                'tag' => 'Best value',
                'features' => ['Custom exercise plan', 'Custom nutrition plan', 'Weekly check-ins', 'Direct messaging with your coach', '2 months free vs monthly'],
            ],
        ];

        foreach ($plans as $order => $data) {
            Plan::firstOrCreate(
                ['name' => $data['name']],
                [
                    'stripe_price_id' => $data['stripe_price_id'],
                    'price' => $data['price'],
                    'billing_cycle' => $data['billing_cycle'],
                    'description' => $data['description'],
                    'tag' => $data['tag'],
                    'order' => $order,
                    'is_active' => true,
                    'features' => $data['features'],
                ]
            );
        }
    }
}
