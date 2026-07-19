<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Help Desk Management System</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>

body{
    background:#f5f7fb;
}

.hero{
    background:linear-gradient(135deg,#0d6efd,#6610f2,#4f46e5);
    position:relative;
}

.hero::before{
    content:'';
    position:absolute;
    width:500px;
    height:500px;
    background:rgba(255,255,255,.08);
    border-radius:50%;
    top:-150px;
    right:-150px;
}

.hero::after{
    content:'';
    position:absolute;
    width:350px;
    height:350px;
    background:rgba(255,255,255,.05);
    border-radius:50%;
    bottom:-120px;
    left:-120px;
}

.hero .card{
    border-radius:20px;
}

.hero .btn{
    border-radius:50px;
}

.hero .badge{
    font-size:14px;
}
.feature-card{
    transition:.3s;
}

.feature-card:hover{
    transform:translateY(-8px);
}

.stats{
    background:white;
}

.footer{
    background:#212529;
    color:white;
}

.icon-circle{

    width:80px;
    height:80px;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    margin:auto;
    background:#0d6efd;
    color:white;
    font-size:35px;

}

</style>

</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">

<div class="container">

<a class="navbar-brand fw-bold" href="/">
<i class="bi bi-headset"></i>
Help Desk System
</a>

<div class="ms-auto">

@auth

<a href="{{ route('dashboard') }}" class="btn btn-primary">
Dashboard
</a>

@else

<a href="{{ route('login') }}" class="btn btn-outline-light me-2">
Login
</a>

<a href="{{ route('register') }}" class="btn btn-warning">
Register
</a>

@endauth

</div>

</div>

</nav>

<section class="hero position-relative overflow-hidden">

    <div class="container py-5">

        <div class="row align-items-center min-vh-100">

            <!-- Left Side -->

            <div class="col-lg-6 text-white">

                <span class="badge bg-warning text-dark px-3 py-2 mb-3">
                    🚀 Modern IT Support Platform
                </span>

                <h1 class="display-3 fw-bold mb-4">

                    Transform Your
                    <span class="text-warning">
                        Help Desk
                    </span>
                    Experience

                </h1>

                <p class="lead mb-4">

                    Streamline IT support with powerful ticket management,
                    technician assignment, SLA monitoring, reports,
                    notifications, attachments, and real-time analytics
                    in one secure platform.

                </p>

                <div class="d-flex flex-wrap gap-3 mb-5">

                    @auth

                        <a href="{{ route('dashboard') }}"
                           class="btn btn-warning btn-lg px-4">

                            <i class="bi bi-speedometer2"></i>

                            Open Dashboard

                        </a>

                    @else

                        <a href="{{ route('login') }}"
                           class="btn btn-warning btn-lg px-4">

                            <i class="bi bi-box-arrow-in-right"></i>

                            Login

                        </a>

                        <a href="{{ route('register') }}"
                           class="btn btn-outline-light btn-lg px-4">

                            <i class="bi bi-person-plus"></i>

                            Create Account

                        </a>

                    @endauth

                </div>

                <div class="row text-center">

                    <div class="col-4">

                        <h2 class="fw-bold">
                            {{ \App\Models\Ticket::count() }}+
                        </h2>

                        <small>Tickets</small>

                    </div>

                    <div class="col-4">

                        <h2 class="fw-bold">
                            {{ \App\Models\User::count() }}+
                        </h2>

                        <small>Users</small>

                    </div>

                    <div class="col-4">

                        <h2 class="fw-bold">

                            {{ \App\Models\Ticket::where('status','Resolved')->count() }}

                        </h2>

                        <small>Resolved</small>

                    </div>

                </div>

            </div>

            <!-- Right Side -->

            <div class="col-lg-6">

                <div class="position-relative">

                    <div class="card shadow-lg border-0 rounded-4">

                        <div class="card-body p-5">

                            <div class="text-center">

                                <div class="display-1 text-primary mb-4">

                                    <i class="bi bi-headset"></i>

                                </div>

                                <h3 class="fw-bold">

                                    Help Desk Dashboard

                                </h3>

                                <p class="text-muted">

                                    Everything you need to manage IT support efficiently.

                                </p>

                            </div>

                            <hr>

                            <div class="d-flex justify-content-between">

                                <span>

                                    <i class="bi bi-ticket-fill text-primary"></i>

                                    Ticket Management

                                </span>

                                <span class="badge bg-success">

                                    Active

                                </span>

                            </div>

                            <hr>

                            <div class="d-flex justify-content-between">

                                <span>

                                    <i class="bi bi-bar-chart-fill text-danger"></i>

                                    Analytics

                                </span>

                                <span class="badge bg-primary">

                                    Live

                                </span>

                            </div>

                            <hr>

                            <div class="d-flex justify-content-between">

                                <span>

                                    <i class="bi bi-bell-fill text-warning"></i>

                                    Notifications

                                </span>

                                <span class="badge bg-warning text-dark">

                                    Instant

                                </span>

                            </div>

                            <hr>

                            <div class="progress" style="height:10px">

                                <div class="progress-bar bg-success"
                                     style="width:92%">

                                </div>

                            </div>

                            <small class="text-muted">

                                System Uptime 99.9%

                            </small>

                        </div>

                    </div>

                    <!-- Floating Cards -->

                    <div class="position-absolute top-0 start-0 translate-middle">

                        <div class="card shadow border-0">

                            <div class="card-body">

                                <i class="bi bi-check-circle-fill text-success"></i>

                                SLA Met

                            </div>

                        </div>

                    </div>

                    <div class="position-absolute bottom-0 end-0 translate-middle">

                        <div class="card shadow border-0">

                            <div class="card-body">

                                <i class="bi bi-people-fill text-primary"></i>

                                Team Collaboration

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>

<section class="py-5">

<div class="container">

<h2 class="text-center mb-5">

Powerful Features

</h2>

<div class="row g-4">

<div class="col-md-4">

<div class="card feature-card shadow h-100">

<div class="card-body text-center">

<div class="icon-circle">

<i class="bi bi-ticket-detailed"></i>

</div>

<h4 class="mt-4">

Ticket Management

</h4>

<p>

Create, assign and resolve tickets quickly.

</p>

</div>

</div>

</div>

<div class="col-md-4">

<div class="card feature-card shadow h-100">

<div class="card-body text-center">

<div class="icon-circle bg-success">

<i class="bi bi-person-workspace"></i>

</div>

<h4 class="mt-4">

Technicians

</h4>

<p>

Assign technicians and monitor workloads.

</p>

</div>

</div>

</div>

<div class="col-md-4">

<div class="card feature-card shadow h-100">

<div class="card-body text-center">

<div class="icon-circle bg-danger">

<i class="bi bi-bar-chart-fill"></i>

</div>

<h4 class="mt-4">

Reports

</h4>

<p>

Interactive dashboards and analytics.

</p>

</div>

</div>

</div>

<div class="col-md-4">

<div class="card feature-card shadow h-100">

<div class="card-body text-center">

<div class="icon-circle bg-warning">

<i class="bi bi-bell-fill"></i>

</div>

<h4 class="mt-4">

Notifications

</h4>

<p>

Receive instant updates on ticket activity.

</p>

</div>

</div>

</div>

<div class="col-md-4">

<div class="card feature-card shadow h-100">

<div class="card-body text-center">

<div class="icon-circle bg-info">

<i class="bi bi-paperclip"></i>

</div>

<h4 class="mt-4">

Attachments

</h4>

<p>

Upload screenshots, PDFs and documents.

</p>

</div>

</div>

</div>

<div class="col-md-4">

<div class="card feature-card shadow h-100">

<div class="card-body text-center">

<div class="icon-circle bg-secondary">

<i class="bi bi-shield-lock-fill"></i>

</div>

<h4 class="mt-4">

Secure Access

</h4>

<p>

Role-based authentication and permissions.

</p>

</div>

</div>

</div>

</div>

</div>

</section>

<section class="bg-primary text-white py-5">

<div class="container text-center">

<h2>

Ready to manage your IT support?

</h2>

<p>

Start using the Help Desk Management System today.

</p>

@auth

<a href="{{ route('dashboard') }}"
class="btn btn-light btn-lg">

Dashboard

</a>

@else

<a href="{{ route('register') }}"
class="btn btn-warning btn-lg">

Create Account

</a>

@endif

</div>

</section>

<footer class="footer py-4">

<div class="container text-center">

<p>

© {{ date('Y') }} Help Desk Management System

</p>

<p>

Developed by Thembelani Buthelezi

</p>

</div>

</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>