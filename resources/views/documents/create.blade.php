@extends('layouts.app')

@section('content')
    <div class="mb-6 rounded-2xl bg-gradient-to-r from-slate-900 via-blue-900 to-indigo-900 p-6 text-white shadow-lg">
        <p class="text-xs uppercase tracking-[0.2em] text-blue-200">Generate Workflow</p>
        <h1 class="mt-1 text-3xl font-bold">Generate Document</h1>
        <p class="mt-1 text-sm text-blue-100">Pick an employee and template to create a styled PDF document instantly.</p>
    </div>

    <form action="{{ route('documents.store') }}" method="POST" class="space-y-6">
        @csrf

        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-slate-900">Document Source</h2>
            <p class="mt-1 text-sm text-slate-500">Select required data for generating your HR letter.</p>

            <div class="mt-5 grid grid-cols-1 gap-5 md:grid-cols-2">
                <div>
                    <label class="block text-sm font-medium text-slate-700">Employee</label>
                    <select name="employee_id" class="mt-1.5 w-full rounded-md border border-slate-300 px-3 py-2.5 @error('employee_id') border-red-500 @enderror" required>
                        <option value="">Select employee</option>
                        @foreach ($employees as $employee)
                            <option value="{{ $employee->id }}" @selected(old('employee_id') == $employee->id)>{{ $employee->first_name }} {{ $employee->last_name }}</option>
                        @endforeach
                    </select>
                    @error('employee_id') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700">Template</label>
                    <select name="document_template_id" class="mt-1.5 w-full rounded-md border border-slate-300 px-3 py-2.5 @error('document_template_id') border-red-500 @enderror" required>
                        <option value="">Select template</option>
                        @foreach ($templates as $template)
                            <option value="{{ $template->id }}" @selected(old('document_template_id') == $template->id)>{{ $template->name }}</option>
                        @endforeach
                    </select>
                    @error('document_template_id') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-slate-900">Delivery Preferences</h2>
            <p class="mt-1 text-sm text-slate-500">Choose whether document should be emailed right after generation.</p>

            <label class="mt-5 inline-flex items-start gap-3">
                <input type="checkbox" name="send_email" value="1" class="mt-1 h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500" @checked(old('send_email'))>
                <span>
                    <span class="block text-sm font-medium text-slate-800">Send email automatically</span>
                    <span class="block text-xs text-slate-500">Employee will receive the generated PDF as an attachment.</span>
                </span>
            </label>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <button type="submit" class="inline-flex items-center rounded-md bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-blue-700">Generate</button>
            <a href="{{ route('documents.index') }}" class="inline-flex items-center rounded-md border border-slate-300 px-5 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">Cancel</a>
        </div>
    </form>
@endsection
