<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@dfitness.test'],
            [
                'name' => 'Gym Admin',
                'password' => Hash::make(env('ADMIN_PASSWORD', 'password')),
                'role' => 'admin',
                'approval_status' => 'approved',
            ],
        );

        User::updateOrCreate([
            'email' => 'test@example.com',
        ], [
            'name' => 'Test Member',
            'password' => Hash::make('password'),
            'role' => 'member',
            'approval_status' => 'approved',
        ]);
    }
}
