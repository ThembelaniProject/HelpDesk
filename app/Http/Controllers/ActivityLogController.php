<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;

class ActivityLogController extends Controller
{
     public function index()
    {
        $activities = ActivityLog::with('user.role')
            ->latest()
            ->paginate(20);

        return view('activity.index', compact('activities'));
    }
}