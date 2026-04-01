@extends('layouts.app')

@section('content')
    <div class="mb-6 rounded-2xl bg-gradient-to-r from-slate-900 via-blue-900 to-cyan-900 p-6 text-white shadow-lg">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-xs uppercase tracking-[0.2em] text-blue-200">Document Center</p>
                <h1 class="mt-1 text-3xl font-bold">Documents</h1>
                <p class="mt-1 text-sm text-blue-100">Review generated documents, track delivery status, and manage records.</p>
            </div>
            <a href="{{ route('documents.create') }}" class="inline-flex items-center rounded-md bg-white px-4 py-2 text-sm font-semibold text-blue-900 hover:bg-blue-50">
                Generate Document
            </a>
        </div>
    </div>

    @if ($documents->isEmpty())
        <div class="rounded-xl border border-dashed border-slate-300 bg-white p-10 text-center shadow-sm">
            <p class="text-lg font-semibold text-slate-700">No documents yet</p>
            <p class="mt-2 text-sm text-slate-500">Generate a document once you have a teammate and a template ready.</p>
            <div class="flex justify-center gap-3 flex-wrap">
                <a href="{{ route('documents.create') }}" class="inline-flex items-center justify-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">Generate document</a>
                <a href="{{ route('employees.index') }}" class="inline-flex items-center justify-center rounded-md border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Add employees</a>
                <a href="{{ route('templates.index') }}" class="inline-flex items-center justify-center rounded-md border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Create template</a>
            </div>
        </div>
    @else
        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
            <table class="min-w-full text-sm text-slate-700">
                <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="p-3 text-left">Employee</th>
                        <th class="p-3 text-left">Template</th>
                        <th class="p-3 text-left">Status</th>
                        <th class="p-3 text-left">Generated</th>
                        <th class="p-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($documents as $document)
                    <tr class="border-t border-slate-100 hover:bg-slate-50/80">
                        <td class="p-3 font-medium text-slate-900">{{ $document->employee->first_name }} {{ $document->employee->last_name }}</td>
                        <td class="p-3">{{ $document->template->name }}</td>
                        <td class="p-3">
                            @php($status = $document->status)
                            <span class="inline-flex items-center rounded-full px-2 py-1 text-xs font-semibold
                                @if ($status === 'sent') bg-green-100 text-green-700
                                @elseif ($status === 'failed') bg-red-100 text-red-700
                                @else bg-gray-100 text-gray-700 @endif">
                                {{ ucfirst($status) }}
                            </span>
                        </td>
                        <td class="p-3">{{ optional($document->generated_at)->toDateTimeString() }}</td>
                        <td class="p-3 space-x-3">
                            <a href="{{ route('documents.show', $document) }}" class="font-medium text-blue-600 hover:text-blue-700">View</a>
                            <form action="{{ route('documents.destroy', $document) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this document?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="font-medium text-red-600 hover:text-red-700">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $documents->links() }}
        </div>
    @endif
@endsection
