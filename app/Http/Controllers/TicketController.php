<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Attachment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\TicketCreatedMail;
use App\Mail\TicketAssignedMail;
use App\Mail\TicketStatusUpdatedMail;
use App\Helpers\ActivityHelper;
use App\Helpers\NotificationHelper;
class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request)
{
    $query = Ticket::with(['user', 'technician', 'category']);
$user = Auth::user();
    // Role-based visibility
    if ($user && $user->role && $user->role->name === 'User') {

    $query->where('user_id', $user->id);

} elseif ($user && $user->role && $user->role->name === 'Technician') {

    $query->where('technician_id', $user->id);

    }

    // Search
    if ($request->filled('search')) {

        $query->where(function ($q) use ($request) {

            $q->where('title', 'like', '%' . $request->search . '%')
              ->orWhere('description', 'like', '%' . $request->search . '%');

        });

    }

    // Status Filter
    if ($request->filled('status')) {

        $query->where('status', $request->status);

    }

    // Sorting
    $sort = $request->get('sort', 'latest');

    if ($sort == 'oldest') {

        $query->oldest();

    } else {

        $query->latest();

    }

    $tickets = $query->paginate(10);

    return view('tickets.index', compact('tickets'));
}
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();

        $technicians = User::whereHas('role', function ($query) {
            $query->where('name', 'Technician');
        })->get();

        return view('tickets.create', compact('categories', 'technicians'));
    }

    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'priority' => 'required',
        'category_id' => 'required|exists:categories,id',
        'attachment' => 'nullable|file|max:10240|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx',
    ]);

    $ticket = Ticket::create([
    'title' => $request->title,
    'description' => $request->description,
    'priority' => $request->priority,
    'status' => 'Open',
    'category_id' => $request->category_id,
    'user_id' => Auth::id(),
    'technician_id' => null,

    'due_date' => match ($request->priority) {

        'Critical' => now()->addHours(4),

        'High' => now()->addHours(8),

        'Medium' => now()->addDay(),

        default => now()->addDays(3),

    },
]);


NotificationHelper::create(
    Auth::id(),
    $ticket->id,
    'Ticket Created',
    'Ticket #'.$ticket->id.' was created.'
);

    ActivityHelper::log(
    'Created Ticket',
    'Created ticket #' . $ticket->id,
    $ticket->id
);

    if ($request->hasFile('attachment')) {

        $file = $request->file('attachment');

        $path = $file->store('attachments', 'public');

        Attachment::create([
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id(),
            'filename' => $file->getClientOriginalName(),
            'filepath' => $path,
            'filetype' => $file->getMimeType(),
            'filesize' => $file->getSize(),
        ]);
    }

  // Load relationships needed by the email
$ticket->load(['user', 'category']);

// Send email notification
Mail::to($ticket->user->email)
    ->send(new TicketCreatedMail($ticket));

return redirect()
    ->route('tickets.show', $ticket)
    ->with('success', 'Ticket created successfully.');
}
    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
{
   $ticket->load([
    'attachments',
    'comments',
    'category',
    'user',
    'technician',
    'activities.user',
]);
    $technicians = User::whereHas('role', function ($query) {
        $query->where('name', 'Technician');
    })->get();

    return view('tickets.show', compact('ticket', 'technicians'));
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        $categories = Category::all();

        $technicians = User::whereHas('role', function ($query) {
            $query->where('name', 'Technician');
        })->get();

        return view('tickets.edit', compact(
            'ticket',
            'categories',
            'technicians'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $ticket)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required',
            'status' => 'required',
            'category_id' => 'required|exists:categories,id',
            'technician_id' => 'nullable|exists:users,id',
        ]);

        $ticket->title = $request->title;
$ticket->description = $request->description;
$ticket->priority = $request->priority;
$ticket->status = $request->status;
$ticket->category_id = $request->category_id;
$ticket->technician_id = $request->technician_id;

// Automatically manage resolved_at
if ($request->status === 'Resolved') {

    $ticket->resolved_at = now();

} else {

    $ticket->resolved_at = null;

}

$ticket->save();

        return redirect()
            ->route('tickets.index')
            ->with('success', 'Ticket updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        $ticket->delete();

        return redirect()
            ->route('tickets.index')
            ->with('success', 'Ticket deleted successfully.');
    }
    public function assign(Request $request, Ticket $ticket)
{
    // Only Admins can assign technicians
    $user = Auth::user();

    if (!$user || !$user->role || $user->role->name !== 'Admin') {
        abort(403, 'Unauthorized');
    }

    $request->validate([
        'technician_id' => 'required|exists:users,id',
    ]);

    // Update the ticket
    $ticket->update([
        'technician_id' => $request->technician_id,
        'status' => 'Assigned',
    ]);

    NotificationHelper::create(
    $ticket->technician_id,
    $ticket->id,
    'Ticket Assigned',
    'You were assigned Ticket #'.$ticket->id
);
    ActivityHelper::log(
    'Assigned Ticket',
    'Assigned Ticket #' . $ticket->id .
    ' to ' .
    $ticket->technician->name,
    $ticket->id
);

    // Reload relationships
    $ticket->load(['user', 'technician', 'category']);

    // Send email to the assigned technician
    Mail::to($ticket->technician->email)
        ->send(new TicketAssignedMail($ticket));

    return back()->with(
        'success',
        'Technician assigned successfully. Email sent to technician.'
    );

}



public function status(Request $request, Ticket $ticket)
{
    $request->validate([
        'status' => 'required'
    ]);

    $ticket->update([
        'status' => $request->status
    ]);

    // Create notification
    NotificationHelper::create(
        $ticket->user_id,
        $ticket->id,
        'Ticket Updated',
        'Status changed to ' . $ticket->status
    );

    $request->validate([
        'status' => 'required'
    ]);

    $data = [];

    if($request->status=="Resolved"){

        $data['resolved_at']=now();

        if($ticket->due_date && now()->greaterThan($ticket->due_date)){

            $data['sla_breached']=true;

        }

    }

    $data['status'] = $request->status;

    $ticket->update($data);
    $ticket->save();

    ActivityHelper::log(
        'Updated Status',
        'Ticket #' . $ticket->id .
        ' changed to ' .
        $request->status,
        $ticket->id
    );

    // Reload relationships
    $ticket->load('user');

    // Send email notification
    Mail::to($ticket->user->email)
        ->send(new TicketStatusUpdatedMail($ticket));

    return back()->with(
        'success',
        'Ticket status updated and email sent.'
    );
}

}
