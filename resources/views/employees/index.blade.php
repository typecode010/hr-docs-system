@extends('layouts.app')

@section('content')
    <div class="mb-6 rounded-2xl bg-gradient-to-r from-slate-900 via-indigo-900 to-slate-900 p-6 text-white shadow-lg">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-xs uppercase tracking-[0.2em] text-indigo-200">Team Directory</p>
                <h1 class="mt-1 text-3xl font-bold">Employees</h1>
                <p class="mt-1 text-sm text-indigo-100">Manage employee records for document generation and communication.</p>
            </div>
            <a href="{{ route('employees.create') }}" class="inline-flex items-center rounded-md bg-white px-4 py-2 text-sm font-semibold text-indigo-900 hover:bg-indigo-50">
                Add Employee
            </a>
        </div>
    </div>

    @if ($employees->isEmpty())
        <div class="rounded-xl border border-dashed border-slate-300 bg-white p-10 text-center shadow-sm">
            <p class="text-lg font-semibold text-slate-700">Team is empty</p>
            <p class="mt-2 text-sm text-slate-500">Add people once they join so you can issue documents and track their progress.</p>
            <a href="{{ route('employees.create') }}" class="mt-4 inline-flex items-center justify-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">Add first employee</a>
        </div>
    @else
        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
            <table class="min-w-full text-sm text-slate-700">
                <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="p-3 text-left">Code</th>
                        <th class="p-3 text-left">Name</th>
                        <th class="p-3 text-left">Email</th>
                        <th class="p-3 text-left">Designation</th>
                        <th class="p-3 text-left">Status</th>
                        <th class="p-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($employees as $employee)
                    <tr class="border-t border-slate-100 hover:bg-slate-50/80">
                        <td class="p-3 font-medium">{{ $employee->employee_code }}</td>
                        <td class="p-3 font-medium text-slate-900">{{ $employee->first_name }} {{ $employee->last_name }}</td>
                        <td class="p-3">{{ $employee->email }}</td>
                        <td class="p-3">{{ $employee->designation }}</td>
                        <td class="p-3">
                            <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $employee->status === 'active' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-200 text-slate-700' }}">
                                {{ ucfirst($employee->status) }}
                            </span>
                        </td>
                        <td class="p-3 space-x-3">
                            <a href="{{ route('employees.show', $employee) }}" class="font-medium text-blue-600 hover:text-blue-700">View</a>
                            <a href="{{ route('employees.edit', $employee) }}" class="font-medium text-emerald-600 hover:text-emerald-700">Edit</a>
                            <form action="{{ route('employees.destroy', $employee) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this employee?')">
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
            {{ $employees->links() }}
        </div>
    @endif
@endsection
