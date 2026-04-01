@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-semibold">Document Templates</h1>
        <a href="{{ route('templates.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded">Add Template</a>
    </div>

    @if ($templates->isEmpty())
        <div class="bg-white rounded shadow border border-dashed border-gray-200 p-8 text-center space-y-3">
            <p class="text-lg font-semibold text-gray-700">Templates are waiting</p>
            <p class="text-sm text-gray-500">Create reusable content so document generation becomes repeatable.</p>
            <a href="{{ route('templates.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white rounded">Add a template</a>
        </div>
    @else
        <div class="bg-white rounded shadow overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="p-3 text-left">Name</th>
                        <th class="p-3 text-left">Type</th>
                        <th class="p-3 text-left">Subject</th>
                        <th class="p-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($templates as $template)
                    <tr class="border-t">
                        <td class="p-3">{{ $template->name }}</td>
                        <td class="p-3">{{ str_replace('_', ' ', ucfirst($template->type)) }}</td>
                        <td class="p-3">{{ $template->subject }}</td>
                        <td class="p-3 space-x-2">
                            <a href="{{ route('templates.show', $template) }}" class="text-blue-600">View</a>
                            <a href="{{ route('templates.edit', $template) }}" class="text-green-600">Edit</a>
                            <form action="{{ route('templates.destroy', $template) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this template?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $templates->links() }}
        </div>
    @endif
@endsection
