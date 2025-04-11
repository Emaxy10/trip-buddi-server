<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;
use App\Models\User;

class AuthouriseRoleByPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $permission): Response
    {

        $roleName = $request->attributes->get('role');
        $role = Role::where('name', $roleName)->first();
        
        if(!$role || !$role->hasPermission($permission)){
            return response()->json(['error' => 'Permission denied.'], 403);
        }
        return $next($request);
    }
}
