<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;

class EmployeesTableSeeder extends Seeder
{
    /**
     * Seed sample employees.
     */
    public function run(): void
    {
        $employees = [
            [
                'employee_code' => 'EMP-1001',
                'first_name' => 'Areeba',
                'last_name' => 'Khan',
                'email' => 'areeba.employee@example.com',
                'phone' => '0300-1234567',
                'designation' => 'HR Officer',
                'department' => 'HR',
                'date_of_joining' => '2024-08-01',
                'status' => 'active',
                'address' => 'Lahore',
            ],
            [
                'employee_code' => 'EMP-1002',
                'first_name' => 'Meerab',
                'last_name' => 'Ali',
                'email' => 'meerab.employee@example.com',
                'phone' => '0300-7654321',
                'designation' => 'Manager',
                'department' => 'Operations',
                'date_of_joining' => '2023-05-15',
                'status' => 'active',
                'address' => 'Islamabad',
            ],
        ];

        foreach ($employees as $employee) {
            Employee::updateOrCreate(
                ['employee_code' => $employee['employee_code']],
                $employee
            );
        }
    }
}
