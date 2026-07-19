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
    /*
    |--------------------------------------------------------------------------
    | Dashboard Cards
    |--------------------------------------------------------------------------
    */

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

    /*
    |--------------------------------------------------------------------------
    | Average Resolution Time
    |--------------------------------------------------------------------------
    */

    $avgResolution = Ticket::whereNotNull('resolved_at')
        ->selectRaw('AVG(TIMESTAMPDIFF(HOUR, created_at, resolved_at)) as avg_hours')
        ->value('avg_hours') ?? 0;

    /*
    |--------------------------------------------------------------------------
    | Category Statistics
    |--------------------------------------------------------------------------
    */

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
    | SLA Statistics
    |--------------------------------------------------------------------------
    */

    $slaMet = Ticket::where('sla_breached', false)
        ->whereNotNull('resolved_at')
        ->count();

    $slaBreached = Ticket::where('sla_breached', true)
        ->count();

    $overdueTickets = Ticket::whereNull('resolved_at')
        ->where('due_date', '<', now())
        ->count();

    $dueSoon = Ticket::whereNull('resolved_at')
        ->whereBetween('due_date', [
            now(),
            now()->addHours(4)
        ])
        ->count();

    /*
    |--------------------------------------------------------------------------
    | Technician Performance
    |--------------------------------------------------------------------------
    */

    $technicianPerformance = User::whereHas('role', function ($q) {
            $q->where('name', 'Technician');
        })
        ->withCount([
            'assignedTickets',
            'assignedTickets as resolved_count' => function ($q) {
                $q->where('status', 'Resolved');
            },
        ])
        ->get()
        ->map(function ($tech) {

            $avgHours = Ticket::where('technician_id', $tech->id)
                ->whereNotNull('resolved_at')
                ->selectRaw('AVG(TIMESTAMPDIFF(HOUR, created_at, resolved_at)) as avg_time')
                ->value('avg_time');

            $slaMet = Ticket::where('technician_id', $tech->id)
                ->where('sla_breached', false)
                ->whereNotNull('resolved_at')
                ->count();

            $slaBreached = Ticket::where('technician_id', $tech->id)
                ->where('sla_breached', true)
                ->count();

            $totalResolved = max($tech->resolved_count, 1);

            $tech->avg_hours = round($avgHours ?? 0, 1);

            $tech->sla_percentage = round(
                ($slaMet / $totalResolved) * 100,
                1
            );

            $tech->sla_breached = $slaBreached;

            return $tech;
        })
        ->sortByDesc('sla_percentage');

    /*
    |--------------------------------------------------------------------------
    | Latest Tickets
    |--------------------------------------------------------------------------
    */

    $recentTickets = Ticket::with([
            'user',
            'category',
            'technician'
        ])
        ->latest()
        ->take(10)
        ->get();

    /*
|--------------------------------------------------------------------------
| Ticket Status Chart
|--------------------------------------------------------------------------
*/

$statusLabels = [
    'Open',
    'Assigned',
    'In Progress',
    'Resolved',
    'Closed'
];

$statusData = [
    Ticket::where('status','Open')->count(),
    Ticket::where('status','Assigned')->count(),
    Ticket::where('status','In Progress')->count(),
    Ticket::where('status','Resolved')->count(),
    Ticket::where('status','Closed')->count(),
];

/*
|--------------------------------------------------------------------------
| Priority Chart
|--------------------------------------------------------------------------
*/

$priorityLabels = [
    'Critical',
    'High',
    'Medium',
    'Low'
];

$priorityData = [
    Ticket::where('priority','Critical')->count(),
    Ticket::where('priority','High')->count(),
    Ticket::where('priority','Medium')->count(),
    Ticket::where('priority','Low')->count(),
];

/*
|--------------------------------------------------------------------------
| Monthly Tickets
|--------------------------------------------------------------------------
*/

$monthlyLabels = [];
$monthlyData = [];

for($i=5;$i>=0;$i--)
{
    $month = now()->subMonths($i);

    $monthlyLabels[] = $month->format('M');

    $monthlyData[] = Ticket::whereYear('created_at',$month->year)
        ->whereMonth('created_at',$month->month)
        ->count();
}

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
        'categoryStats',
        'topTechnicians',
        'recentTickets',
        'avgResolution',
        'slaMet',
        'slaBreached',
        'overdueTickets',
        'dueSoon',
        'technicianPerformance',
        'statusLabels',
        'statusData',
        'priorityLabels',
        'priorityData',
        'monthlyLabels',
        'monthlyData',
    ));
}
}