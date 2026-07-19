<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $avgResolution = 0;
        $avgResolution = Ticket::whereNotNull('resolved_at')
    ->selectRaw('AVG(TIMESTAMPDIFF(HOUR, created_at, resolved_at)) as avg_hours')
    ->value('avg_hours') ?? 0;
        // Dashboard Cards
        $totalTickets = Ticket::count();
        $openTickets = Ticket::where('status', 'Open')->count();
        $assignedTickets = Ticket::where('status', 'Assigned')->count();
        $progressTickets = Ticket::where('status', 'In Progress')->count();
        $resolvedTickets = Ticket::where('status', 'Resolved')->count();
        $closedTickets = Ticket::where('status', 'Closed')->count();

        $criticalTickets = Ticket::where('priority', 'Critical')->count();

        $totalUsers = User::count();

        $technicians = User::whereHas('role', function ($q) {
            $q->where('name', 'Technician');
        })->count();

        $categories = Category::count();
        $categoryStats = Category::withCount('tickets')
    ->orderByDesc('tickets_count')
    ->get();

        /*
        |--------------------------------------------------------------------------
        | Top Technicians
        |--------------------------------------------------------------------------
        */

        $topTechnicians = User::whereHas('role', function ($q) {
                $q->where('name', 'Technician');
            })
            ->withCount('assignedTickets')
            ->orderByDesc('assigned_tickets_count')
            ->take(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Latest Tickets
        |--------------------------------------------------------------------------
        */

        $recentTickets = Ticket::with(['user', 'category', 'technician'])
            ->latest()
            ->take(10)
            ->get();

        return view('dashboard.index', compact(
    'totalTickets',
    'openTickets',
    'assignedTickets',
    'progressTickets',
    'resolvedTickets',
    'closedTickets',
    'criticalTickets',
    'totalUsers',
    'technicians',
    'categories',
    'topTechnicians',
    'recentTickets',
    'categoryStats',
    'avgResolution'
));
    }
}