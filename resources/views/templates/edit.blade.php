@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-semibold mb-4">Edit Template</h1>

    <form action="{{ route('templates.update', $template) }}" method="POST" class="bg-white p-6 rounded shadow space-y-4">
        @csrf
        @method('PUT')
        @include('templates.form', ['template' => $template])
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Update</button>
    </form>
@endsection
