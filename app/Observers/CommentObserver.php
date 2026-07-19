<?php

namespace App\Observers;

use App\Models\Comment;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class CommentObserver
{
    public function created(Comment $comment): void
    {
        ActivityLog::create([
            'ticket_id'   => $comment->ticket_id,
            'user_id'     => Auth::id(),
            'action'      => 'Comment Added',
            'description' => 'Added a comment.',
        ]);
    }

    public function deleted(Comment $comment): void
    {
        ActivityLog::create([
            'ticket_id'   => $comment->ticket_id,
            'user_id'     => Auth::id(),
            'action'      => 'Comment Deleted',
            'description' => 'Deleted a comment.',
        ]);
    }
}