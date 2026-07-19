<?php

namespace App\Helpers;

use App\Models\Notification;

class NotificationHelper
{
    public static function create(
        $userId,
        $ticketId,
        $title,
        $message
    )
    {
        Notification::create([
            'user_id'=>$userId,
            'ticket_id'=>$ticketId,
            'title'=>$title,
            'message'=>$message,
        ]);
    }
}