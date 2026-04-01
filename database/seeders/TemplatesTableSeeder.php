<?php

namespace Database\Seeders;

use App\Models\DocumentTemplate;
use Illuminate\Database\Seeder;

class TemplatesTableSeeder extends Seeder
{
    /**
     * Seed initial document templates.
     */
    public function run(): void
    {
        DocumentTemplate::updateOrCreate(
            ['name' => 'Offer Letter'],
            [
                'type' => 'offer_letter',
                'subject' => 'Offer Letter - {{name}}',
                'body' => "Dear {{name}},\n\nWe are pleased to offer you the position of {{designation}} in the {{department}} department. Your start date will be {{joining_date}}.\n\nSincerely,\nHR Department",
                'placeholders' => ['{{name}}', '{{designation}}', '{{department}}', '{{joining_date}}'],
            ]
        );

        DocumentTemplate::updateOrCreate(
            ['name' => 'Appointment Letter'],
            [
                'type' => 'appointment_letter',
                'subject' => 'Appointment Letter - {{name}}',
                'body' => "Dear {{name}},\n\nThis is to confirm your appointment as {{designation}} effective {{joining_date}}. We look forward to your contributions.\n\nRegards,\nHR Department",
                'placeholders' => ['{{name}}', '{{designation}}', '{{joining_date}}'],
            ]
        );

        DocumentTemplate::updateOrCreate(
            ['name' => 'Experience Letter'],
            [
                'type' => 'experience_letter',
                'subject' => 'Experience Letter - {{name}}',
                'body' => "To whom it may concern,\n\nThis is to certify that {{name}} worked with us as {{designation}} in the {{department}} department.\n\nSincerely,\nHR Department",
                'placeholders' => ['{{name}}', '{{designation}}', '{{department}}'],
            ]
        );
    }
}
