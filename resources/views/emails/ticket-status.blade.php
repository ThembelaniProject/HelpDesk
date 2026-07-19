<!DOCTYPE html>
<html>
<head>
    <title>Status Updated</title>
</head>
<body>

<h2>Hello {{ $ticket->user->name }},</h2>

<p>Your Help Desk ticket status has changed.</p>

<hr>

<p><strong>Ticket #:</strong> {{ $ticket->id }}</p>

<p><strong>Title:</strong> {{ $ticket->title }}</p>

<p><strong>New Status:</strong>
<b>{{ $ticket->status }}</b>
</p>

<hr>

<p>Thank you for using the Help Desk System.</p>

</body>
</html>