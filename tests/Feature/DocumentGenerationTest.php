<?php

namespace Tests\Feature;

use App\Models\Document;
use App\Models\DocumentTemplate;
use App\Models\Employee;
use App\Models\User;
use App\Services\PdfService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DocumentGenerationTest extends TestCase
{
    use RefreshDatabase;

    public function test_hr_can_generate_document_without_email(): void
    {
        $user = User::factory()->create(['role' => 'hr']);
        $employee = Employee::factory()->create(['status' => 'active']);
        $template = DocumentTemplate::factory()->create([
            'subject' => 'Offer Letter',
            'body' => 'Hello {{name}}, welcome as {{designation}}.',
        ]);

        $this->app->instance(PdfService::class, new class {
            public function generate(string $html, string $fileName): string
            {
                return storage_path('app/documents/'.$fileName);
            }
        });

        $response = $this->actingAs($user)->post(route('documents.store'), [
            'employee_id' => $employee->id,
            'document_template_id' => $template->id,
            'send_email' => false,
        ]);

        $response->assertRedirect(route('documents.index'));

        $this->assertDatabaseCount('documents', 1);
        $document = Document::first();

        $this->assertSame('generated', $document->status);
        $this->assertNotEmpty($document->pdf_path);

        $this->assertDatabaseHas('document_logs', [
            'document_id' => $document->id,
            'status' => 'generated',
        ]);
    }

    public function test_document_history_page_loads(): void
    {
        $user = User::factory()->create(['role' => 'hr']);

        $response = $this->actingAs($user)->get(route('history.index'));

        $response->assertStatus(200);
    }
}
