<?php

namespace App\Observers;

use App\Models\Attachment;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class AttachmentObserver
{
    public function created(Attachment $attachment): void
    {
        ActivityLog::create([
            'ticket_id'   => $attachment->ticket_id,
            'user_id'     => Auth::id(),
            'action'      => 'Attachment Uploaded',
            'description' => $attachment->filename,
        ]);
    }

    public function deleted(Attachment $attachment): void
    {
        ActivityLog::create([
            'ticket_id'   => $attachment->ticket_id,
            'user_id'     => Auth::id(),
            'action'      => 'Attachment Deleted',
            'description' => $attachment->filename,
        ]);
    }
}