<?php

namespace App\Http\Controllers;

use App\Models\DocumentLog;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DocumentHistoryController extends Controller
{
    public function index(Request $request)
    {
        $query = DocumentLog::with(['document.employee', 'document.template'])->latest();

        $filters = [
            'status' => $request->get('status'),
            'date_from' => $request->get('date_from'),
            'date_to' => $request->get('date_to'),
            'search' => $request->get('search'),
        ];

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['date_from'])) {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }

        if (!empty($filters['search'])) {
            $query->where(function ($sub) use ($filters) {
                $term = '%'.$filters['search'].'%';
                $sub->where('message', 'like', $term)
                    ->orWhereHas('document.employee', function ($emp) use ($term) {
                        $emp->where('first_name', 'like', $term)
                            ->orWhere('last_name', 'like', $term)
                            ->orWhere('email', 'like', $term);
                    })
                    ->orWhereHas('document.template', function ($tpl) use ($term) {
                        $tpl->where('name', 'like', $term);
                    });
            });
        }

        $logs = $query->paginate(20)->appends(array_filter($filters));

        return view('history.index', compact('logs', 'filters'));
    }

    public function export(Request $request): StreamedResponse
    {
        $query = DocumentLog::with(['document.employee', 'document.template'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->get('date_from'));
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->get('date_to'));
        }

        if ($request->filled('search')) {
            $query->where(function ($sub) use ($request) {
                $term = '%'.$request->get('search').'%';
                $sub->where('message', 'like', $term)
                    ->orWhereHas('document.employee', function ($emp) use ($term) {
                        $emp->where('first_name', 'like', $term)
                            ->orWhere('last_name', 'like', $term)
                            ->orWhere('email', 'like', $term);
                    })
                    ->orWhereHas('document.template', function ($tpl) use ($term) {
                        $tpl->where('name', 'like', $term);
                    });
            });
        }

        $fileName = 'document-history-'.now()->format('Ymd_His').'.csv';

        return response()->streamDownload(function () use ($query) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, ['Employee', 'Email', 'Template', 'Status', 'Message', 'Time']);

            $query->chunk(200, function ($logs) use ($handle) {
                foreach ($logs as $log) {
                    $employeeName = trim(($log->document->employee->first_name ?? '').' '.($log->document->employee->last_name ?? ''));
                    $employeeEmail = $log->document->employee->email ?? '';
                    $templateName = $log->document->template->name ?? '';

                    fputcsv($handle, [
                        $employeeName,
                        $employeeEmail,
                        $templateName,
                        $log->status,
                        $log->message,
                        $log->created_at->toDateTimeString(),
                    ]);
                }
            });

            fclose($handle);
        }, $fileName, [
            'Content-Type' => 'text/csv',
        ]);
    }
}
