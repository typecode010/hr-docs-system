@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-semibold mb-4">Create User</h1>

    <form action="{{ route('admin.users.store') }}" method="POST" class="bg-white p-6 rounded shadow space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium">Name</label>
            <input type="text" name="name" value="{{ old('name') }}" class="mt-1 w-full border rounded px-3 py-2" required>
            @error('name')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="mt-1 w-full border rounded px-3 py-2" required>
            @error('email')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium">Role</label>
            <select name="role" class="mt-1 w-full border rounded px-3 py-2" required>
                @foreach ($roles as $role)
                    <option value="{{ $role }}" @selected(old('role') === $role)>{{ ucfirst($role) }}</option>
                @endforeach
            </select>
            @error('role')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium">Password</label>
            <input type="password" name="password" class="mt-1 w-full border rounded px-3 py-2" required>
            @error('password')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium">Confirm Password</label>
            <input type="password" name="password_confirmation" class="mt-1 w-full border rounded px-3 py-2" required>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Save</button>
            <a href="{{ route('admin.users.index') }}" class="px-4 py-2 border rounded">Cancel</a>
        </div>
    </form>
@endsection
