<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Additional client accounts, on top of the default admin/user pair
     * created in DatabaseSeeder. All share the password "123456789".
     */
    public function run(): void
    {
        $userRole = Role::firstOrCreate(['name' => 'user']);

        $clients = [
            ['username' => 'Alex Carter', 'email' => 'alex.carter@example.com'],
            ['username' => 'Maria Gomez', 'email' => 'maria.gomez@example.com'],
            ['username' => 'Liam Chen', 'email' => 'liam.chen@example.com'],
            ['username' => 'Sophie Turner', 'email' => 'sophie.turner@example.com'],
        ];

        foreach ($clients as $client) {
            $user = User::firstOrCreate(
                ['email' => $client['email']],
                [
                    'username' => $client['username'],
                    'password' => '123456789',
                ]
            );

            $user->roles()->syncWithoutDetaching([$userRole->id]);
        }
    }
}
