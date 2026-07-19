<!DOCTYPE html>
<html>
<head>
    <title>Ticket Assigned</title>
</head>
<body>

<h2>Hello {{ $ticket->technician->name }},</h2>

<p>A new Help Desk ticket has been assigned to you.</p>

<hr>

<p><strong>Ticket #:</strong> {{ $ticket->id }}</p>

<p><strong>Title:</strong> {{ $ticket->title }}</p>

<p><strong>Priority:</strong> {{ $ticket->priority }}</p>

<p><strong>Status:</strong> {{ $ticket->status }}</p>

<p><strong>Description:</strong></p>

<p>{{ $ticket->description }}</p>

<hr>

<p>Please log in to the Help Desk System to begin working on this ticket.</p>

</body>
</html>