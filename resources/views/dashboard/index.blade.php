@extends('layouts.app')

@section('content')
    @php($role = auth()->user()?->role)

    <div class="mb-6 rounded-2xl bg-gradient-to-r from-slate-900 via-blue-900 to-indigo-900 p-6 text-white shadow-lg">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-xs uppercase tracking-[0.2em] text-blue-200">Control Center</p>
                <h1 class="mt-1 text-3xl font-bold">Dashboard</h1>
                <p class="mt-1 text-sm text-blue-100">Quick view of today's HR document workflow.</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('documents.create') }}" class="rounded-md bg-white px-4 py-2 text-sm font-semibold text-blue-900 hover:bg-blue-50">Generate Document</a>
                <a href="{{ route('history.index') }}" class="rounded-md border border-blue-200/40 px-4 py-2 text-sm font-semibold text-blue-100 hover:bg-blue-800/40">View History</a>
            @if (in_array($role, ['admin', 'hr'], true))
                <a href="{{ route('employees.index') }}" class="rounded-md border border-blue-200/40 px-4 py-2 text-sm font-semibold text-blue-100 hover:bg-blue-800/40">Employees</a>
            @endif
            @if ($role === 'admin')
                <a href="{{ route('admin.users.index') }}" class="rounded-md border border-blue-200/40 px-4 py-2 text-sm font-semibold text-blue-100 hover:bg-blue-800/40">Users</a>
            @endif
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="text-xs uppercase tracking-wide text-slate-500">Employees</div>
            <div class="mt-1 text-3xl font-bold text-slate-900">{{ $stats['employees'] }}</div>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="text-xs uppercase tracking-wide text-slate-500">Templates</div>
            <div class="mt-1 text-3xl font-bold text-slate-900">{{ $stats['templates'] }}</div>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="text-xs uppercase tracking-wide text-slate-500">Documents</div>
            <div class="mt-1 text-3xl font-bold text-slate-900">{{ $stats['documents'] }}</div>
        </div>
    </div>

    @if ($role === 'admin')
        <div class="mt-8">
            <h2 class="text-lg font-semibold mb-4">Admin Overview</h2>
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                    <div class="text-xs uppercase tracking-wide text-slate-500">Users</div>
                    <div class="mt-1 text-2xl font-bold text-slate-900">{{ $adminStats['users'] ?? 0 }}</div>
                </div>
                <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                    <div class="text-xs uppercase tracking-wide text-slate-500">Active Employees</div>
                    <div class="mt-1 text-2xl font-bold text-slate-900">{{ $adminStats['active_employees'] ?? 0 }}</div>
                </div>
                <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                    <div class="text-xs uppercase tracking-wide text-slate-500">This Month</div>
                    <div class="mt-1 text-2xl font-bold text-slate-900">{{ $adminStats['documents_this_month'] ?? 0 }}</div>
                </div>
                <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                    <div class="text-xs uppercase tracking-wide text-slate-500">Sent</div>
                    <div class="mt-1 text-2xl font-bold text-emerald-700">{{ $adminStats['sent'] ?? 0 }}</div>
                </div>
                <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                    <div class="text-xs uppercase tracking-wide text-slate-500">Failed</div>
                    <div class="mt-1 text-2xl font-bold text-red-600">{{ $adminStats['failed'] ?? 0 }}</div>
                </div>
            </div>

            <div class="mt-6 grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="text-lg font-semibold mb-4">User Roles</h3>
                    <ul class="space-y-2 text-sm">
                        <li class="flex items-center justify-between border-b border-slate-100 pb-2">
                            <span>Admins</span>
                            <span class="font-semibold">{{ $roleCounts['admin'] ?? 0 }}</span>
                        </li>
                        <li class="flex items-center justify-between border-b border-slate-100 pb-2">
                            <span>HR Staff</span>
                            <span class="font-semibold">{{ $roleCounts['hr'] ?? 0 }}</span>
                        </li>
                        <li class="flex items-center justify-between">
                            <span>Managers</span>
                            <span class="font-semibold">{{ $roleCounts['manager'] ?? 0 }}</span>
                        </li>
                    </ul>
                </div>

                <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm lg:col-span-2">
                    <h3 class="text-lg font-semibold mb-4">Recent Documents</h3>
                    @if ($recentDocuments->isEmpty())
                        <p class="text-gray-500">No documents generated yet.</p>
                    @else
                        <ul class="space-y-3">
                            @foreach ($recentDocuments as $doc)
                                <li class="flex items-start justify-between border-b border-slate-100 pb-2">
                                    <div>
                                        <div class="font-medium">{{ $doc->template->name ?? 'Document' }}</div>
                                        <div class="text-sm text-gray-500">{{ $doc->employee->first_name ?? '' }} {{ $doc->employee->last_name ?? '' }}</div>
                                    </div>
                                    <span class="text-sm text-gray-600">{{ ucfirst($doc->status) }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm lg:col-span-3">
                    <h3 class="text-lg font-semibold mb-4">Recent Users</h3>
                    @if ($recentUsers->isEmpty())
                        <p class="text-gray-500">No user activity yet.</p>
                    @else
                        <ul class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                            @foreach ($recentUsers as $recentUser)
                                <li class="flex items-center justify-between rounded-md border border-slate-200 px-3 py-2">
                                    <div>
                                        <div class="font-medium">{{ $recentUser->name }}</div>
                                        <div class="text-gray-500">{{ $recentUser->email }}</div>
                                    </div>
                                    <span class="text-xs uppercase tracking-wide text-gray-500">{{ ucfirst($recentUser->role) }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    @endif

    @if ($role === 'hr')
        <div class="mt-8">
            <h2 class="text-lg font-semibold mb-4">HR Overview</h2>
            <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
                <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                    <div class="text-xs uppercase tracking-wide text-slate-500">Active Employees</div>
                    <div class="mt-1 text-2xl font-bold text-slate-900">{{ $hrStats['active_employees'] ?? 0 }}</div>
                </div>
                <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                    <div class="text-xs uppercase tracking-wide text-slate-500">Inactive</div>
                    <div class="mt-1 text-2xl font-bold text-slate-900">{{ $hrStats['inactive_employees'] ?? 0 }}</div>
                </div>
                <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                    <div class="text-xs uppercase tracking-wide text-slate-500">Templates</div>
                    <div class="mt-1 text-2xl font-bold text-slate-900">{{ $hrStats['templates'] ?? 0 }}</div>
                </div>
                <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                    <div class="text-xs uppercase tracking-wide text-slate-500">This Month</div>
                    <div class="mt-1 text-2xl font-bold text-slate-900">{{ $hrStats['documents_this_month'] ?? 0 }}</div>
                </div>
                <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                    <div class="text-xs uppercase tracking-wide text-slate-500">Generated</div>
                    <div class="mt-1 text-2xl font-bold text-blue-700">{{ $hrStats['generated'] ?? 0 }}</div>
                </div>
                <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                    <div class="text-xs uppercase tracking-wide text-slate-500">Failed</div>
                    <div class="mt-1 text-2xl font-bold text-red-600">{{ $hrStats['failed'] ?? 0 }}</div>
                </div>
            </div>

            <div class="mt-6 grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="text-lg font-semibold mb-4">Recent Employees</h3>
                    @if ($recentEmployees->isEmpty())
                        <p class="text-gray-500">No employees added yet.</p>
                    @else
                        <ul class="space-y-3">
                            @foreach ($recentEmployees as $employee)
                                <li class="flex items-start justify-between border-b border-slate-100 pb-2">
                                    <div>
                                        <div class="font-medium">{{ $employee->first_name }} {{ $employee->last_name }}</div>
                                        <div class="text-sm text-gray-500">{{ $employee->designation }}</div>
                                    </div>
                                    <span class="text-sm text-gray-600">{{ ucfirst($employee->status) }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="text-lg font-semibold mb-4">Recent Documents</h3>
                    @if ($recentDocuments->isEmpty())
                        <p class="text-gray-500">No documents generated yet.</p>
                    @else
                        <ul class="space-y-3">
                            @foreach ($recentDocuments as $doc)
                                <li class="flex items-start justify-between border-b border-slate-100 pb-2">
                                    <div>
                                        <div class="font-medium">{{ $doc->template->name ?? 'Document' }}</div>
                                        <div class="text-sm text-gray-500">{{ $doc->employee->first_name ?? '' }} {{ $doc->employee->last_name ?? '' }}</div>
                                    </div>
                                    <span class="text-sm text-gray-600">{{ ucfirst($doc->status) }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    @endif

    @if ($role === 'manager')
        <div class="mt-8">
            <h2 class="text-lg font-semibold mb-4">Manager Overview</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                    <div class="text-xs uppercase tracking-wide text-slate-500">Sent</div>
                    <div class="mt-1 text-2xl font-bold text-emerald-700">{{ $managerStats['sent'] ?? 0 }}</div>
                </div>
                <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                    <div class="text-xs uppercase tracking-wide text-slate-500">Generated</div>
                    <div class="mt-1 text-2xl font-bold text-blue-700">{{ $managerStats['generated'] ?? 0 }}</div>
                </div>
                <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                    <div class="text-xs uppercase tracking-wide text-slate-500">Failed</div>
                    <div class="mt-1 text-2xl font-bold text-red-600">{{ $managerStats['failed'] ?? 0 }}</div>
                </div>
                <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                    <div class="text-xs uppercase tracking-wide text-slate-500">This Month</div>
                    <div class="mt-1 text-2xl font-bold text-slate-900">{{ $managerStats['this_month'] ?? 0 }}</div>
                </div>
            </div>

            <div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="text-lg font-semibold mb-4">Last 6 Months</h2>
                    <ul class="space-y-2">
                        @foreach ($managerStats['monthly'] ?? [] as $row)
                            <li class="flex items-center justify-between border-b border-slate-100 pb-2">
                                <span>{{ $row['label'] }}</span>
                                <span class="font-semibold">{{ $row['count'] }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="text-lg font-semibold mb-4">Recent Documents</h2>
                    @if ($managerRecent->isEmpty())
                        <p class="text-gray-500">No documents generated yet.</p>
                    @else
                        <ul class="space-y-3">
                            @foreach ($managerRecent as $doc)
                                <li class="flex items-start justify-between border-b border-slate-100 pb-2">
                                    <div>
                                        <div class="font-medium">{{ $doc->template->name ?? 'Document' }}</div>
                                        <div class="text-sm text-gray-500">{{ $doc->employee->first_name ?? '' }} {{ $doc->employee->last_name ?? '' }}</div>
                                    </div>
                                    <span class="text-sm text-gray-600">{{ ucfirst($doc->status) }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    @endif
@endsection
