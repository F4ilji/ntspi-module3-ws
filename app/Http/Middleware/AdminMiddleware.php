<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if(auth()->user()->role !== 'admin') {
            return response()->json(['message' => 'Page not found'], 404);
        }
        return $next($request);
    }
}
