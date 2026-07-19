<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class TechnicianController extends Controller
{
    /**
     * Display the Technician Dashboard.
     */
    public function index()
    {
        $tickets = Ticket::with([
            'user',
            'category',
            'technician',
            'attachments',
            'comments'
        ])
        ->where('technician_id', Auth::id())
        ->latest()
        ->get();

        $open = $tickets->where('status', 'Open')->count();
        $assigned = $tickets->where('status', 'Assigned')->count();
        $progress = $tickets->where('status', 'In Progress')->count();
        $resolved = $tickets->where('status', 'Resolved')->count();
        $closed = $tickets->where('status', 'Closed')->count();

        return view('technician.dashboard', compact(
            'tickets',
            'open',
            'assigned',
            'progress',
            'resolved',
            'closed'
        ));
    }
}