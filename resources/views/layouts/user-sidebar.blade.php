<div class="sidebar">

    <h3 class="text-center text-white mt-4">
        Customer
    </h3>

    <hr>

    <a href="{{ route('tickets.index') }}">
        <i class="bi bi-ticket"></i> My Tickets
    </a>

    <a href="{{ route('tickets.create') }}">
        <i class="bi bi-plus-circle"></i> Create Ticket
    </a>

    <a href="{{ route('profile.edit') }}">
        <i class="bi bi-person"></i> My Profile
    </a>

    <form method="POST" action="{{ route('logout') }}" class="mt-4 px-3">
        @csrf
        <button class="btn btn-danger w-100">
            Logout
        </button>
    </form>

</div>