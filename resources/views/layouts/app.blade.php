<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Help Desk System</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body{
            background:#f5f6fa;
            overflow-x:hidden;
        }

        .sidebar{
            width:250px;
            min-height:100vh;
            background:#0d6efd;
        }

        .sidebar a{
            color:#fff;
            display:block;
            padding:14px 20px;
            text-decoration:none;
        }

        .sidebar a:hover{
            background:#084298;
        }

        .content{
            flex:1;
            padding:25px;
        }

        .card{
            border:none;
            box-shadow:0 2px 10px rgba(0,0,0,.08);
        }

        .badge-high{
            background:red;
        }

        .badge-medium{
            background:orange;
        }

        .badge-low{
            background:green;
        }
    </style>

</head>

<body>

<div class="d-flex">

    @auth

        @if(auth()->user()->role && auth()->user()->role->name == 'Admin')
            @include('layouts.admin-sidebar')

        @elseif(auth()->user()->role && auth()->user()->role->name == 'Technician')
            @include('layouts.technician-sidebar')

        @else
            @include('layouts.user-sidebar')
        @endif

    @endauth

    <div class="content">

        @include('layouts.navbar')

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')

        @include('layouts.footer')

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>