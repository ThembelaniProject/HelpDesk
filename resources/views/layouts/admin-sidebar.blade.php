<div class="sidebar">

    <h3 class="text-center text-white mt-4">
        Help Desk
    </h3>

    <hr>

    <a href="{{ route('dashboard') }}">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>

    <a href="{{ route('tickets.index') }}">
        <i class="bi bi-ticket"></i> Tickets
    </a>

    <a href="{{ route('categories.index') }}">
        <i class="bi bi-folder"></i> Categories
    </a>

    <a href="{{ route('users.index') }}">
        <i class="bi bi-people"></i> Users
    </a>

    <a href="{{ route('roles.index') }}">
        <i class="bi bi-person-badge"></i> Roles
    </a>

    <a href="{{ route('reports.index') }}">
        <i class="bi bi-file-earmark-bar-graph"></i> Reports
    </a>
  

    <a href="#">
        <i class="bi bi-gear"></i> Settings
    </a>


    <a href="{{ route('activity.index') }}" class="nav-link">

        <i class="bi bi-clock-history"></i>

        <span>Activity Logs</span>

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