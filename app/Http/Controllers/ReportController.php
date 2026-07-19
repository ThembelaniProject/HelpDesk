<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        // ===============================
        // Summary Cards
        // ===============================

        $totalTickets = Ticket::count();

        $openTickets = Ticket::where('status','Open')->count();

        $assignedTickets = Ticket::where('status','Assigned')->count();

        $progressTickets = Ticket::where('status','In Progress')->count();

        $resolvedTickets = Ticket::where('status','Resolved')->count();

        $closedTickets = Ticket::where('status','Closed')->count();

        $totalUsers = User::count();

        $technicians = User::whereHas('role',function($q){

            $q->where('name','Technician');

        })->count();

        $categories = Category::count();

        // ===============================
        // Monthly Tickets
        // ===============================

        $monthlyTickets = Ticket::select(
                DB::raw("MONTH(created_at) as month"),
                DB::raw("COUNT(*) as total")
            )
            ->groupBy(DB::raw("MONTH(created_at)"))
            ->pluck('total','month')
            ->toArray();

        $monthlyData=[];

        for($i=1;$i<=12;$i++){

            $monthlyData[]=$monthlyTickets[$i] ?? 0;

        }

        // ===============================
        // Priority Chart
        // ===============================

        $priorityData=[

            Ticket::where('priority','Low')->count(),

            Ticket::where('priority','Medium')->count(),

            Ticket::where('priority','High')->count(),

            Ticket::where('priority','Critical')->count(),

        ];

        // ===============================
        // Status Chart
        // ===============================

        $statusData=[

            $openTickets,

            $assignedTickets,

            $progressTickets,

            $resolvedTickets,

            $closedTickets

        ];

        // ===============================
        // Top Technicians
        // ===============================

        $topTechnicians=User::whereHas('role',function($q){

                $q->where('name','Technician');

            })
            ->withCount('assignedTickets')
            ->orderByDesc('assigned_tickets_count')
            ->take(10)
            ->get();

        // ===============================
        // Categories
        // ===============================

        $categoryStats=Category::withCount('tickets')
            ->orderByDesc('tickets_count')
            ->get();

        // ===============================
        // Average Resolution Time
        // ===============================

        $avgResolution=Ticket::whereNotNull('updated_at')
            ->where('status','Resolved')
            ->selectRaw('AVG(TIMESTAMPDIFF(HOUR,created_at,updated_at)) as avg_hours')
            ->value('avg_hours');

        return view('reports.index',compact(

            'totalTickets',
            'openTickets',
            'assignedTickets',
            'progressTickets',
            'resolvedTickets',
            'closedTickets',
            'totalUsers',
            'technicians',
            'categories',

            'monthlyData',
            'priorityData',
            'statusData',

            'topTechnicians',

            'categoryStats',

            'avgResolution'

        ));
    }
}