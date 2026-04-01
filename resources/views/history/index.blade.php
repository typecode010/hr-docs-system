@extends('layouts.app')

@section('content')
    <div class="mb-6 rounded-2xl bg-gradient-to-r from-slate-900 via-violet-900 to-slate-900 p-6 text-white shadow-lg">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-xs uppercase tracking-[0.2em] text-violet-200">Audit Trail</p>
                <h1 class="mt-1 text-3xl font-bold">Document History</h1>
                <p class="mt-1 text-sm text-violet-100">Track generation, delivery outcomes, and message logs across your workflow.</p>
            </div>
            <a href="{{ route('history.export', request()->query()) }}" class="inline-flex items-center rounded-md bg-white px-4 py-2 text-sm font-semibold text-violet-900 hover:bg-violet-50">Export CSV</a>
        </div>
    </div>

    <form method="GET" action="{{ route('history.index') }}" class="mb-5 grid grid-cols-1 gap-4 rounded-xl border border-slate-200 bg-white p-5 shadow-sm md:grid-cols-4">
        <div>
            <label class="block text-sm font-medium text-slate-700">Status</label>
            <select name="status" class="mt-1.5 w-full rounded-md border border-slate-300 px-3 py-2.5">
                <option value="">All</option>
                @foreach (['generated', 'sent', 'failed'] as $status)
                    <option value="{{ $status }}" @selected(($filters['status'] ?? '') === $status)>{{ ucfirst($status) }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700">Date From</label>
            <input type="date" name="date_from" value="{{ $filters['date_from'] ?? '' }}" class="mt-1.5 w-full rounded-md border border-slate-300 px-3 py-2.5">
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700">Date To</label>
            <input type="date" name="date_to" value="{{ $filters['date_to'] ?? '' }}" class="mt-1.5 w-full rounded-md border border-slate-300 px-3 py-2.5">
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700">Search</label>
            <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Employee / template / message" class="mt-1.5 w-full rounded-md border border-slate-300 px-3 py-2.5">
        </div>
        <div class="flex gap-3 md:col-span-4">
            <button type="submit" class="inline-flex items-center rounded-md bg-violet-600 px-4 py-2 text-sm font-semibold text-white hover:bg-violet-700">Apply Filters</button>
            <a href="{{ route('history.index') }}" class="inline-flex items-center rounded-md border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Reset</a>
        </div>
    </form>

    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <table class="min-w-full text-sm text-slate-700">
            <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                <tr>
                    <th class="p-3 text-left">Employee</th>
                    <th class="p-3 text-left">Document</th>
                    <th class="p-3 text-left">Status</th>
                    <th class="p-3 text-left">Message</th>
                    <th class="p-3 text-left">Time</th>
                </tr>
            </thead>
            <tbody>
            @forelse ($logs as $log)
                <tr class="border-t border-slate-100 hover:bg-slate-50/80">
                    <td class="p-3 font-medium text-slate-900">{{ $log->document->employee->first_name ?? '' }} {{ $log->document->employee->last_name ?? '' }}</td>
                    <td class="p-3">{{ $log->document->template->name ?? 'N/A' }}</td>
                    <td class="p-3">
                        <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold
                            @if ($log->status === 'sent') bg-emerald-100 text-emerald-700
                            @elseif ($log->status === 'failed') bg-red-100 text-red-700
                            @else bg-slate-100 text-slate-700 @endif">
                            {{ ucfirst($log->status) }}
                        </span>
                    </td>
                    <td class="p-3">{{ $log->message }}</td>
                    <td class="p-3">{{ $log->created_at->toDateTimeString() }}</td>
                </tr>
            @empty
                <tr class="border-t">
                    <td class="p-3 text-center text-gray-500" colspan="5">No history records found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $logs->links() }}
    </div>
@endsection
