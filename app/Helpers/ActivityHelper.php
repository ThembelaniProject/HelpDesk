<?php

namespace App\Helpers;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class ActivityHelper
{
    public static function log($action, $description, $ticketId = null)
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'ticket_id' => $ticketId,
            'action' => $action,
            'description' => $description,
        ]);
    }
}