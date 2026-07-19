<!DOCTYPE html>
<html>
<head>
    <title>New Comment</title>
</head>
<body>

<h2>Hello {{ $comment->ticket->user->name }},</h2>

<p>A new comment has been added to your ticket.</p>

<hr>

<p><strong>Ticket:</strong> {{ $comment->ticket->title }}</p>

<p><strong>Commented By:</strong>
{{ $comment->user->name }}
</p>

<p><strong>Comment:</strong></p>

<p>{{ $comment->comment }}</p>

<hr>

<p>Please log in to view the discussion.</p>

</body>
</html>