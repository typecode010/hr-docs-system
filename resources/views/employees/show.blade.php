@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-semibold mb-4">Employee Details</h1>

    <div class="bg-white p-6 rounded shadow">
        <p><strong>Code:</strong> {{ $employee->employee_code }}</p>
        <p><strong>Name:</strong> {{ $employee->first_name }} {{ $employee->last_name }}</p>
        <p><strong>Email:</strong> {{ $employee->email }}</p>
        <p><strong>Designation:</strong> {{ $employee->designation }}</p>
        <p><strong>Department:</strong> {{ $employee->department }}</p>
        <p><strong>Status:</strong> {{ ucfirst($employee->status) }}</p>
        <p><strong>Joining Date:</strong> {{ optional($employee->date_of_joining)->toDateString() }}</p>
        <p><strong>Address:</strong> {{ $employee->address }}</p>
    </div>
@endsection
