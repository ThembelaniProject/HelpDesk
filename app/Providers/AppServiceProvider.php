<?php

namespace App\Observers;

use App\Models\Ticket;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class TicketObserver
{
    public function created(Ticket $ticket): void
    {
        ActivityLog::create([
            'ticket_id'   => $ticket->id,
            'user_id'     => Auth::id(),
            'action'      => 'Ticket Created',
            'description' => 'Created Ticket #' . $ticket->id,
        ]);
    }

    public function updated(Ticket $ticket): void
    {
        if ($ticket->wasChanged('technician_id')) {

            ActivityLog::create([
                'ticket_id'   => $ticket->id,
                'user_id'     => Auth::id(),
                'action'      => 'Technician Assigned',
                'description' => 'Assigned technician.',
            ]);
        }

        if ($ticket->wasChanged('status')) {

            ActivityLog::create([
                'ticket_id'   => $ticket->id,
                'user_id'     => Auth::id(),
                'action'      => 'Status Updated',
                'description' => 'Status changed to ' . $ticket->status,
            ]);
        }
    }

    public function deleted(Ticket $ticket): void
    {
        ActivityLog::create([
            'ticket_id'   => $ticket->id,
            'user_id'     => Auth::id(),
            'action'      => 'Ticket Deleted',
            'description' => 'Ticket was deleted.',
        ]);
    }
}