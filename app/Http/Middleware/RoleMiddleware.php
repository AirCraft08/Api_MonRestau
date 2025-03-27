<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (auth()->user() && auth()->user()->role === $role) {
            return $next($request);
        }

        return redirect('/');  // Redirige si l'utilisateur n'a pas le rôle adéquat
    }
}
