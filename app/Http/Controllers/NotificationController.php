<?php

namespace App\Http\Controllers;

use App\Models\Notification;

class NotificationController extends Controller
{
    public function read(Notification $notification)
    {
        $notification->update([
            'is_read'=>true
        ]);

        if($notification->ticket_id){

            return redirect()->route(
                'tickets.show',
                $notification->ticket_id
            );

        }

        return back();
    }
}