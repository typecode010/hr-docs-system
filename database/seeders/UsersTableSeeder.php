<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Seed default admin and HR users.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@hrdocs.local'],
            [
                'name' => 'Admin User',
                'role' => 'admin',
                'password' => Hash::make('password'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'hr@hrdocs.local'],
            [
                'name' => 'HR User',
                'role' => 'hr',
                'password' => Hash::make('password'),
            ]
        );
    }
}
