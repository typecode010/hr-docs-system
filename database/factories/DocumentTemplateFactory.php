<?php

namespace Database\Factories;

use App\Models\DocumentTemplate;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DocumentTemplate>
 */
class DocumentTemplateFactory extends Factory
{
    protected $model = DocumentTemplate::class;

    public function definition(): array
    {
        return [
            'name' => fake()->words(3, true),
            'type' => fake()->randomElement(['offer_letter', 'appointment_letter', 'experience_letter']),
            'subject' => 'HR Document - '.fake()->sentence(3),
            'body' => 'Hello {{name}}, your designation is {{designation}} in {{department}}.',
            'placeholders' => ['{{name}}', '{{designation}}', '{{department}}'],
        ];
    }
}
