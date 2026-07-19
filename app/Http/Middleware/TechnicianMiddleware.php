<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TechnicianMiddleware
{

    public function handle(
        Request $request,
        Closure $next
    ): Response
    {

        // Check if user is logged in
        if (!Auth::check()) {

            return redirect('/login');

        }


        // Check if user has Technician role
        if (
            !Auth::user()->role ||
            Auth::user()->role->name !== 'Technician'
        ) {

            abort(403, 'Access Denied');

        }


        return $next($request);

    }

}