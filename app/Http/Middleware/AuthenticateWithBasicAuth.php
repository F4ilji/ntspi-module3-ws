<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateWithBasicAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $user = User::where('email', $request->getUser())->first();
    
        if ($user && Hash::check($request->getPassword(), $user->password)) {
            return $next($request);
        }
    
        return response()->json([
            'message' => 'Invalid credentials'
        ], 401);
    }
}
