<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Employee;
use App\Models\DocumentTemplate;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = request()->user();

        $stats = [
            'employees' => Employee::count(),
            'templates' => DocumentTemplate::count(),
            'documents' => Document::count(),
        ];

        $documentStats = [
            'sent' => Document::where('status', 'sent')->count(),
            'failed' => Document::where('status', 'failed')->count(),
            'generated' => Document::where('status', 'generated')->count(),
        ];

        $employeeStats = [
            'active' => Employee::where('status', 'active')->count(),
            'inactive' => Employee::where('status', 'inactive')->count(),
        ];

        $startOfMonth = Carbon::now()->startOfMonth();
        $documentsThisMonth = Document::where('generated_at', '>=', $startOfMonth)->count();

        $roleCounts = [
            'admin' => User::where('role', 'admin')->count(),
            'hr' => User::where('role', 'hr')->count(),
            'manager' => User::where('role', 'manager')->count(),
        ];

        $recentDocuments = Document::with(['employee', 'template'])
            ->latest()
            ->take(5)
            ->get();

        $recentEmployees = Employee::latest()
            ->take(5)
            ->get();

        $recentUsers = User::latest()
            ->take(5)
            ->get();

        $adminStats = [];
        $hrStats = [];
        $managerStats = [];
        $managerRecent = collect();

        if ($user && $user->role === 'admin') {
            $adminStats = [
                'users' => User::count(),
                'documents_this_month' => $documentsThisMonth,
                'sent' => $documentStats['sent'],
                'failed' => $documentStats['failed'],
                'active_employees' => $employeeStats['active'],
            ];
        }

        if ($user && $user->role === 'hr') {
            $hrStats = [
                'active_employees' => $employeeStats['active'],
                'inactive_employees' => $employeeStats['inactive'],
                'templates' => $stats['templates'],
                'documents_this_month' => $documentsThisMonth,
                'generated' => $documentStats['generated'],
                'failed' => $documentStats['failed'],
            ];
        }

        if ($user && $user->role === 'manager') {
            $managerStats['sent'] = $documentStats['sent'];
            $managerStats['failed'] = $documentStats['failed'];
            $managerStats['generated'] = $documentStats['generated'];
            $managerStats['this_month'] = $documentsThisMonth;

            $monthly = [];
            for ($i = 5; $i >= 0; $i--) {
                $month = Carbon::now()->subMonths($i);
                $monthly[] = [
                    'label' => $month->format('M Y'),
                    'count' => Document::whereYear('generated_at', $month->year)
                        ->whereMonth('generated_at', $month->month)
                        ->count(),
                ];
            }

            $managerStats['monthly'] = $monthly;

            $managerRecent = Document::with(['employee', 'template'])
                ->latest()
                ->take(5)
                ->get();
        }

        return view('dashboard.index', compact(
            'stats',
            'adminStats',
            'hrStats',
            'managerStats',
            'managerRecent',
            'documentStats',
            'employeeStats',
            'roleCounts',
            'recentDocuments',
            'recentEmployees',
            'recentUsers'
        ));
    }
}
