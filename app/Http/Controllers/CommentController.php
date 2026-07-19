<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\CommentAddedMail;
use App\Helpers\ActivityHelper;
use App\Helpers\NotificationHelper;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'ticket_id' => 'required|exists:tickets,id',
            'comment' => 'required|string',
        ]);

        // Create the comment
        $comment = Comment::create([
            'ticket_id' => $request->ticket_id,
            'user_id'   => Auth::id(),
            'comment'   => $request->comment,
        ]);

        // Fetch the ticket
        $ticket = Ticket::find($request->ticket_id);

        NotificationHelper::create(
            $ticket->user_id,
            $ticket->id,
            'New Comment',
           
            Auth::user()->name.' commented on Ticket #'.$ticket->id
        );

        ActivityHelper::log(

    'Added Comment',

    'Comment added to Ticket #' .
    $request->ticket_id

);

        // Load relationships for the email
        $comment->load([
            'user',
            'ticket.user',
        ]);

        // Send email to the ticket owner
        Mail::to($comment->ticket->user->email)
            ->send(new CommentAddedMail($comment));

        return back()->with(
            'success',
            'Comment added successfully. Email notification sent.'
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        //
    }
}