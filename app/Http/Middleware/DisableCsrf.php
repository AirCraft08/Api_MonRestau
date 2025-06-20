<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DisableCsrf
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Ce middleware doit être appliqué AVANT VerifyCsrfToken
        // Il n'y a pas besoin de logique spéciale ici
        // Le simple fait d'appliquer ce middleware va bypasser le CSRF
        return $next($request);
    }
}