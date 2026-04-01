@extends('layouts.app')

@section('content')
    @php
        preg_match_all('/{{\s*([a-zA-Z0-9_]+)\s*}}/', $template->body ?? '', $matches);
        $detectedPlaceholders = collect($matches[1] ?? [])->unique()->values();
        $templateTypeLabel = str_replace('_', ' ', ucwords($template->type ?? '', '_'));
    @endphp

    <div class="mb-6 rounded-2xl bg-gradient-to-r from-slate-900 via-blue-900 to-slate-900 p-6 text-white shadow-lg">
        <p class="text-xs uppercase tracking-[0.2em] text-blue-200">Template Details</p>
        <div class="mt-2 flex flex-wrap items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold leading-tight">{{ $template->name }}</h1>
                <p class="mt-1 text-sm text-blue-100">Use this template to generate consistent HR documents with auto-filled placeholders.</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('templates.index') }}" class="inline-flex items-center rounded-md border border-blue-300/50 px-4 py-2 text-sm font-medium text-blue-100 hover:bg-blue-800/40">
                    Back to Templates
                </a>
                <a href="{{ route('templates.edit', $template) }}" class="inline-flex items-center rounded-md bg-white px-4 py-2 text-sm font-semibold text-blue-900 hover:bg-blue-50">
                    Edit Template
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Type</p>
            <p class="mt-2 text-lg font-semibold text-slate-900">{{ $templateTypeLabel }}</p>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm lg:col-span-2">
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Subject</p>
            <p class="mt-2 text-lg font-semibold text-slate-900">{{ $template->subject ?: 'No subject provided' }}</p>
        </div>
    </div>

    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <h2 class="text-xl font-semibold text-slate-900">Detected Placeholders</h2>
            <span class="text-sm text-slate-500">{{ $detectedPlaceholders->count() }} found</span>
        </div>

        @if ($detectedPlaceholders->isEmpty())
            <p class="mt-3 rounded-lg border border-amber-200 bg-amber-50 px-3 py-2 text-sm text-amber-700">
                No placeholders detected in this template body.
            </p>
        @else
            <div class="mt-4 flex flex-wrap gap-2">
                @foreach ($detectedPlaceholders as $placeholder)
                    <span class="inline-flex items-center rounded-full border border-blue-200 bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">
                        {{ '{' }}{{ '{' }}{{ $placeholder }}{{ '}' }}{{ '}' }}
                    </span>
                @endforeach
            </div>
        @endif
    </div>

    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        <h2 class="text-xl font-semibold text-slate-900">Body Preview</h2>
        <p class="mt-1 text-sm text-slate-500">This exact content is used during document generation and then converted to PDF.</p>

        <div class="mt-4 rounded-lg border border-slate-200 bg-slate-50 p-5 whitespace-pre-line leading-7 text-slate-800">
            {{ $template->body }}
        </div>
    </div>
@endsection
