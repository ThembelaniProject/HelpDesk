<div class="sidebar">

    <h3 class="text-center text-white mt-4">
        Technician
    </h3>

    <hr>

    <a href="{{ route('technician.dashboard') }}">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>

    <a href="{{ route('tickets.index') }}">
        <i class="bi bi-ticket"></i> Assigned Tickets
    </a>

    <a href="#">
        <i class="bi bi-check-circle"></i> Update Status
    </a>

    <a href="#">
        <i class="bi bi-paperclip"></i> Attachments
    </a>

<a href="{{ route('profile.edit') }}">

<i class="bi bi-person-circle"></i>

Profile

</a>

    <form method="POST" action="{{ route('logout') }}" class="mt-4 px-3">
        @csrf
        <button class="btn btn-danger w-100">
            Logout
        </button>
    </form>

</div>