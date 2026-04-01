<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::latest()->paginate(15);

        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        return view('employees.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'employee_code' => ['required', 'string', 'max:20', 'unique:employees,employee_code'],
            'first_name' => ['required', 'string', 'max:50'],
            'last_name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'unique:employees,email'],
            'phone' => ['nullable', 'string', 'max:30'],
            'designation' => ['required', 'string', 'max:100'],
            'department' => ['nullable', 'string', 'max:100'],
            'date_of_joining' => ['nullable', 'date'],
            'status' => ['required', 'in:active,inactive'],
            'address' => ['nullable', 'string'],
        ]);

        Employee::create($data);

        return redirect()->route('employees.index');
    }

    public function show(Employee $employee)
    {
        return view('employees.show', compact('employee'));
    }

    public function edit(Employee $employee)
    {
        return view('employees.edit', compact('employee'));
    }

    public function update(Request $request, Employee $employee)
    {
        $data = $request->validate([
            'employee_code' => ['required', 'string', 'max:20', 'unique:employees,employee_code,'.$employee->id],
            'first_name' => ['required', 'string', 'max:50'],
            'last_name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'unique:employees,email,'.$employee->id],
            'phone' => ['nullable', 'string', 'max:30'],
            'designation' => ['required', 'string', 'max:100'],
            'department' => ['nullable', 'string', 'max:100'],
            'date_of_joining' => ['nullable', 'date'],
            'status' => ['required', 'in:active,inactive'],
            'address' => ['nullable', 'string'],
        ]);

        $employee->update($data);

        return redirect()->route('employees.index');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();

        return redirect()->route('employees.index');
    }
}
