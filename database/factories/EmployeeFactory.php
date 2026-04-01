<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    public function definition(): array
    {
        return [
            'employee_code' => 'EMP'.fake()->unique()->numberBetween(1000, 9999),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'designation' => fake()->jobTitle(),
            'department' => fake()->randomElement(['HR', 'Engineering', 'Finance', 'Operations']),
            'date_of_joining' => fake()->date(),
            'status' => fake()->randomElement(['active', 'inactive']),
            'address' => fake()->address(),
        ];
    }
}
