<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ManagerUserSeeder extends Seeder
{
    /**
     * Run the database seeds for manager accounts.
     */
    public function run(): void
    {
        User::updateOrCreate([
            'email' => 'manager@hrdocs.local',
        ], [
            'name' => 'Manager User',
            'role' => 'manager',
            'password' => Hash::make('manager123'),
        ]);
    }
}
