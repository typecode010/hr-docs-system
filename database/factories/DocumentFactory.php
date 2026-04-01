<?php

namespace Database\Factories;

use App\Models\Document;
use App\Models\DocumentTemplate;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Document>
 */
class DocumentFactory extends Factory
{
    protected $model = Document::class;

    public function definition(): array
    {
        return [
            'employee_id' => Employee::factory(),
            'document_template_id' => DocumentTemplate::factory(),
            'generated_by' => User::factory(),
            'status' => 'generated',
            'pdf_path' => storage_path('app/documents/fake.pdf'),
            'generated_at' => now(),
            'sent_at' => null,
            'error_message' => null,
        ];
    }
}
