<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;   

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::create(
            [
                'id' => 1,
                'name' => 'admin',
            ]
        );

        User::factory()->create([
            'id' => 1,
            'username' => 'Admin',
            'email' => 'admin@proton.me',
            'password' =>  password_hash(123456789, PASSWORD_BCRYPT)
        ]);

        DB::table('user_roles')->insert(
            [
                'role_id' => 1,
                'user_id' => 1
            ]
        );

    }
}
