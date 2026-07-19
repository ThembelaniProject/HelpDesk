<?php

namespace App\Helpers;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class ActivityHelper
{
    public static function log($action, $description = null)
    {
        if (Auth::check()) {

            ActivityLog::create([

                'user_id' => Auth::id(),

                'action' => $action,

                'description' => $description,

            ]);

        }
    }
}