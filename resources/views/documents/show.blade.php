@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-semibold mb-4">Document Details</h1>

    <div class="bg-white p-6 rounded shadow space-y-2">
        <p><strong>Employee:</strong> {{ $document->employee->first_name }} {{ $document->employee->last_name }}</p>
        <p><strong>Template:</strong> {{ $document->template->name }}</p>
        <p><strong>Status:</strong> {{ ucfirst($document->status) }}</p>
        <p><strong>Generated At:</strong> {{ optional($document->generated_at)->toDateTimeString() }}</p>
        <p><strong>Sent At:</strong> {{ optional($document->sent_at)->toDateTimeString() }}</p>
        <p><strong>PDF Path:</strong> {{ $document->pdf_path }}</p>
        @if ($document->error_message)
            <p class="text-red-600"><strong>Error:</strong> {{ $document->error_message }}</p>
        @endif

        <div class="mt-4 flex flex-wrap gap-3">
            <a href="{{ route('documents.preview', $document) }}" class="inline-flex items-center rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">Preview PDF</a>
            <a href="{{ route('documents.download', $document) }}" class="inline-flex items-center rounded bg-gray-700 px-4 py-2 text-white hover:bg-gray-800">Download PDF</a>
            <form action="{{ route('documents.resend', $document) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="inline-flex items-center rounded bg-emerald-600 px-4 py-2 text-white hover:bg-emerald-700">Resend Email</button>
            </form>
        </div>
    </div>

    <div class="mt-6">
        <h2 class="text-xl font-semibold mb-2">History</h2>
        <div class="bg-white rounded shadow">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="p-3 text-left">Status</th>
                        <th class="p-3 text-left">Message</th>
                        <th class="p-3 text-left">Time</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($document->logs as $log)
                    <tr class="border-t">
                        <td class="p-3">{{ ucfirst($log->status) }}</td>
                        <td class="p-3">{{ $log->message }}</td>
                        <td class="p-3">{{ $log->created_at->toDateTimeString() }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
