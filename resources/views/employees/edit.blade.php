@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-semibold mb-4">Edit Employee</h1>

    <form action="{{ route('employees.update', $employee) }}" method="POST" class="bg-white p-6 rounded shadow space-y-4">
        @csrf
        @method('PUT')
        @include('employees.form', ['employee' => $employee])
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Update</button>
    </form>
@endsection
