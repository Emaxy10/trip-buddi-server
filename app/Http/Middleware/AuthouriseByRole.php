<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthouriseByRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        
        $user = User::find(Auth::id());
        if (!$user) {
            return response()->json(['error' => 'Not Unauthenticated.'], 401);
        }
        if (!$user->hasRole($role)) {
            return response()->json(['error' => 'User does not have role']);
        }

         // Attach the role to the request
        $request->attributes->set('role', $role);
        return $next($request);
    }
}
