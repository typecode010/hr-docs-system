<?php

namespace App\Services;

use App\Models\Document;
use App\Models\DocumentLog;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EmailDeliveryService
{
    /**
     * Send a document PDF to the employee.
     */
    public function send(Document $document, string $to, string $subject, string $body): array
    {
        try {
            Mail::raw($body, function ($message) use ($to, $subject, $document) {
                $message->to($to)
                    ->subject($subject)
                    ->attach($document->pdf_path);
            });

            DocumentLog::create([
                'document_id' => $document->id,
                'status' => 'sent',
                'message' => 'Document sent via email.',
            ]);

            return ['status' => 'sent', 'message' => 'Email sent successfully.'];
        } catch (\Throwable $exception) {
            Log::error('Email delivery failed', [
                'document_id' => $document->id,
                'email' => $to,
                'error' => $exception->getMessage(),
            ]);

            DocumentLog::create([
                'document_id' => $document->id,
                'status' => 'failed',
                'message' => 'Email sending failed: '.$exception->getMessage(),
            ]);

            return ['status' => 'failed', 'message' => 'Email sending failed.'];
        }
    }
}
