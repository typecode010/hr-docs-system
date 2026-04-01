@extends('layouts.app')

@section('content')
    <div class="bg-white shadow rounded-lg p-8 space-y-6">
        <h1 class="text-4xl font-bold">Automated HR Document Generation & Email System</h1>
        <p class="text-lg text-gray-600">
            Generate offer letters, appointment letters, and experience letters in a few clicks, convert them to PDF,
            and deliver them directly to your employees via email.
        </p>

        <div class="flex flex-wrap gap-3">
            <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-6 py-3 rounded bg-blue-600 text-white font-semibold hover:bg-blue-700">
                Login
            </a>
            <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-6 py-3 rounded border border-gray-300 text-gray-700 hover:bg-gray-50">
                Register
            </a>
        </div>

        <section class="grid grid-cols-1 gap-4 sm:grid-cols-3">
            <div class="p-4 border rounded shadow-sm">
                <h2 class="text-lg font-semibold">Employees</h2>
                <p class="text-sm text-gray-600">Store and manage employee records with departments, job titles, and join dates.</p>
            </div>
            <div class="p-4 border rounded shadow-sm">
                <h2 class="text-lg font-semibold">Templates</h2>
                <p class="text-sm text-gray-600">Create placeholders such as @{{ name }}, @{{ designation }}, and @{{ date }} to personalize documents.</p>
            </div>
            <div class="p-4 border rounded shadow-sm">
                <h2 class="text-lg font-semibold">Documents</h2>
                <p class="text-sm text-gray-600">Generate PDFs, preview them, and dispatch them through email delivery with logging.</p>
            </div>
        </section>
    </div>
@endsection
