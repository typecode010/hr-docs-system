<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentLog;
use App\Models\DocumentTemplate;
use App\Models\Employee;
use App\Services\DocumentGenerationService;
use App\Services\EmailDeliveryService;
use App\Services\PdfService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = Document::with(['employee', 'template'])->latest()->paginate(15);

        return view('documents.index', compact('documents'));
    }

    public function create()
    {
        $employees = Employee::orderBy('first_name')->get();
        $templates = DocumentTemplate::orderBy('name')->get();

        return view('documents.create', compact('employees', 'templates'));
    }

    public function store(
        Request $request,
        DocumentGenerationService $generator,
        PdfService $pdfService,
        EmailDeliveryService $mailer
    ) {
        $data = $request->validate([
            'employee_id' => ['required', 'exists:employees,id'],
            'document_template_id' => ['required', 'exists:document_templates,id'],
            'send_email' => ['nullable', 'boolean'],
        ]);

        $document = Document::create([
            'employee_id' => $data['employee_id'],
            'document_template_id' => $data['document_template_id'],
            'generated_by' => $request->user()?->id,
            'status' => 'generated',
            'generated_at' => now(),
        ]);

        $employee = Employee::findOrFail($data['employee_id']);
        $template = DocumentTemplate::findOrFail($data['document_template_id']);

        $html = $generator->render($template, $employee);
        $fileName = 'document_'.$document->id.'_'.Str::random(6).'.pdf';
        $pdfPath = $pdfService->generate($html, $fileName);

        $document->update([
            'pdf_path' => $pdfPath,
        ]);

        DocumentLog::create([
            'document_id' => $document->id,
            'status' => 'generated',
            'message' => 'Document generated successfully.',
        ]);

        $emailFailed = false;

        if ($request->boolean('send_email')) {
            $subject = $template->subject ?? $template->name;
            $result = $mailer->send($document, $employee->email, $subject, 'Please find your document attached.');

            if ($result['status'] === 'sent') {
                $document->update([
                    'status' => 'sent',
                    'sent_at' => now(),
                ]);
            } else {
                $emailFailed = true;
                $document->update([
                    'status' => 'failed',
                    'error_message' => $result['message'],
                ]);
            }
        }

        $redirect = redirect()->route('documents.index');

        if ($request->boolean('send_email') && $emailFailed) {
            return $redirect->with('error', 'Document generated, but email delivery failed.');
        }

        return $redirect->with('success', $request->boolean('send_email') ? 'Document generated and emailed successfully.' : 'Document generated successfully.');
    }

    public function show(Document $document)
    {
        $document->load(['employee', 'template', 'logs']);

        return view('documents.show', compact('document'));
    }

    public function preview(Document $document, PdfService $pdfService)
    {
        $document->loadMissing(['employee', 'template']);

        if (!$this->pdfExists($document)) {
            return redirect()->route('documents.show', $document)->with('error', 'PDF file not found.');
        }

        return $pdfService->stream($document->pdf_path, $this->buildFileName($document));
    }

    public function download(Document $document, PdfService $pdfService)
    {
        $document->loadMissing(['employee', 'template']);

        if (!$this->pdfExists($document)) {
            return redirect()->route('documents.show', $document)->with('error', 'PDF file not found.');
        }

        return $pdfService->download($document->pdf_path, $this->buildFileName($document));
    }

    public function resend(Document $document, EmailDeliveryService $mailer): RedirectResponse
    {
        $document->loadMissing(['employee', 'template']);

        if (!$this->pdfExists($document)) {
            return redirect()->route('documents.show', $document)->with('error', 'PDF file not found.');
        }

        if (!$document->employee?->email) {
            return redirect()->route('documents.show', $document)->with('error', 'Employee email not found.');
        }

        DocumentLog::create([
            'document_id' => $document->id,
            'status' => 'sent',
            'message' => 'Email resend requested.',
        ]);

        $subject = $document->template?->subject ?? $document->template?->name ?? 'HR Document';
        $result = $mailer->send($document, $document->employee->email, $subject, 'Please find your document attached.');

        if ($result['status'] === 'sent') {
            $document->update([
                'status' => 'sent',
                'sent_at' => now(),
                'error_message' => null,
            ]);

            return redirect()->route('documents.show', $document)->with('success', 'Document resent successfully.');
        }

        $document->update([
            'status' => 'failed',
            'error_message' => $result['message'],
        ]);

        return redirect()->route('documents.show', $document)->with('error', 'Resend failed.');
    }

    public function destroy(Document $document)
    {
        $document->delete();

        return redirect()->route('documents.index');
    }

    private function pdfExists(Document $document): bool
    {
        return $document->pdf_path && File::exists($document->pdf_path);
    }

    private function buildFileName(Document $document): string
    {
        $employeeName = trim($document->employee->first_name.' '.$document->employee->last_name);
        $templateName = $document->template->name ?? 'document';

        return Str::slug($employeeName.'-'.$templateName.'-'.$document->id).'.pdf';
    }
}
