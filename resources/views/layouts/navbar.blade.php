<nav class="navbar navbar-expand-lg bg-white rounded shadow-sm mb-4">

    <div class="container-fluid">

        <h4 class="mb-0">
            Dashboard
        </h4>

        @auth

        <div class="d-flex align-items-center">

            {{-- ===================== --}}
            {{-- Notification Bell --}}
            {{-- ===================== --}}

            @php
                $unread = auth()->user()->notifications()
                            ->where('is_read', false)
                            ->count();

                $notifications = auth()->user()->notifications()
                                ->latest()
                                ->take(10)
                                ->get();
            @endphp

            <div class="dropdown me-4">

                <a class="nav-link position-relative"
                   href="#"
                   role="button"
                   data-bs-toggle="dropdown"
                   aria-expanded="false">

                    <i class="bi bi-bell-fill fs-4"></i>

                    @if($unread > 0)

                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">

                            {{ $unread }}

                        </span>

                    @endif

                </a>

                <ul class="dropdown-menu dropdown-menu-end shadow"
                    style="width:360px; max-height:400px; overflow-y:auto;">

                    <li class="dropdown-header fw-bold">

                        Notifications

                    </li>

                    <li><hr class="dropdown-divider"></li>

                    @forelse($notifications as $notification)

                        <li>

                            <a class="dropdown-item"
                               href="{{ route('notifications.read', $notification) }}">

                                <strong>

                                    {{ $notification->title }}

                                </strong>

                                <br>

                                <small class="text-muted">

                                    {{ $notification->message }}

                                </small>

                                <br>

                                <small class="text-secondary">

                                    {{ $notification->created_at->diffForHumans() }}

                                </small>

                            </a>

                        </li>

                    @empty

                        <li>

                            <span class="dropdown-item text-center text-muted">

                                No notifications

                            </span>

                        </li>

                    @endforelse

                </ul>

            </div>

            {{-- ===================== --}}
            {{-- User Profile --}}
            {{-- ===================== --}}

            <div class="dropdown">

                <a href="#"
                   class="d-flex align-items-center text-decoration-none text-dark"
                   data-bs-toggle="dropdown"
                   aria-expanded="false">

                    @if(auth()->user()->profile_photo)

                        <img
                            src="{{ asset('storage/' . auth()->user()->profile_photo) }}"
                            class="rounded-circle border"
                            width="45"
                            height="45"
                            style="object-fit:cover;">

                    @else

                        <i class="bi bi-person-circle fs-1 text-primary"></i>

                    @endif

                    <div class="ms-2 text-start">

                        <small class="text-muted d-block">

                            Welcome,

                        </small>

                        <strong>

                            {{ auth()->user()->name }}

                        </strong>

                    </div>

                </a>

                <ul class="dropdown-menu dropdown-menu-end shadow">

                    <li>

                        <a class="dropdown-item"
                           href="{{ route('profile.edit') }}">

                            <i class="bi bi-person"></i>

                            My Profile

                        </a>

                    </li>

                    <li>

                        <a class="dropdown-item"
                           href="{{ route('tickets.index') }}">

                            <i class="bi bi-ticket"></i>

                            My Tickets

                        </a>

                    </li>

                    <li>

                        <hr class="dropdown-divider">

                    </li>

                    <li>

                        <form method="POST"
                              action="{{ route('logout') }}">

                            @csrf

                            <button type="submit"
                                    class="dropdown-item text-danger">

                                <i class="bi bi-box-arrow-right"></i>

                                Logout

                            </button>

                        </form>

                    </li>

                </ul>

            </div>

        </div>

        @endauth

    </div>

</nav>