<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium">Employee Code</label>
        <input name="employee_code" value="{{ old('employee_code', $employee->employee_code ?? '') }}" class="mt-1 w-full border rounded p-2 @error('employee_code') border-red-500 @enderror" required>
        @error('employee_code') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-sm font-medium">First Name</label>
        <input name="first_name" value="{{ old('first_name', $employee->first_name ?? '') }}" class="mt-1 w-full border rounded p-2 @error('first_name') border-red-500 @enderror" required>
        @error('first_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-sm font-medium">Last Name</label>
        <input name="last_name" value="{{ old('last_name', $employee->last_name ?? '') }}" class="mt-1 w-full border rounded p-2 @error('last_name') border-red-500 @enderror" required>
        @error('last_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-sm font-medium">Email</label>
        <input name="email" type="email" value="{{ old('email', $employee->email ?? '') }}" class="mt-1 w-full border rounded p-2 @error('email') border-red-500 @enderror" required>
        @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-sm font-medium">Phone</label>
        <input name="phone" value="{{ old('phone', $employee->phone ?? '') }}" class="mt-1 w-full border rounded p-2 @error('phone') border-red-500 @enderror">
        @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-sm font-medium">Designation</label>
        <input name="designation" value="{{ old('designation', $employee->designation ?? '') }}" class="mt-1 w-full border rounded p-2 @error('designation') border-red-500 @enderror" required>
        @error('designation') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-sm font-medium">Department</label>
        <input name="department" value="{{ old('department', $employee->department ?? '') }}" class="mt-1 w-full border rounded p-2 @error('department') border-red-500 @enderror">
        @error('department') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-sm font-medium">Date of Joining</label>
        <input name="date_of_joining" type="date" value="{{ old('date_of_joining', optional($employee->date_of_joining ?? null)->toDateString()) }}" class="mt-1 w-full border rounded p-2 @error('date_of_joining') border-red-500 @enderror">
        @error('date_of_joining') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-sm font-medium">Status</label>
        <select name="status" class="mt-1 w-full border rounded p-2 @error('status') border-red-500 @enderror">
            <option value="active" @selected(old('status', $employee->status ?? 'active') === 'active')>Active</option>
            <option value="inactive" @selected(old('status', $employee->status ?? '') === 'inactive')>Inactive</option>
        </select>
        @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>
    <div class="md:col-span-2">
        <label class="block text-sm font-medium">Address</label>
        <textarea name="address" class="mt-1 w-full border rounded p-2 @error('address') border-red-500 @enderror">{{ old('address', $employee->address ?? '') }}</textarea>
        @error('address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>
</div>
