<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Ticket Created</title>
</head>

<body>

    <h2>Help Desk Ticket Created Successfully</h2>

    <p>Hello <strong>{{ $ticket->user->name }}</strong>,</p>

    <p>Your support ticket has been created successfully.</p>

    <hr>

    <p><strong>Ticket ID:</strong> #{{ $ticket->id }}</p>

    <p><strong>Title:</strong> {{ $ticket->title }}</p>

    <p><strong>Category:</strong> {{ $ticket->category->name }}</p>

    <p><strong>Priority:</strong> {{ $ticket->priority }}</p>

    <p><strong>Status:</strong> {{ $ticket->status }}</p>

    <p><strong>Description:</strong></p>

    <p>{{ $ticket->description }}</p>

    <hr>

    <p>
        Thank you for using the Help Desk System.
        Our support team will review your request shortly.
    </p>

</body>

</html>