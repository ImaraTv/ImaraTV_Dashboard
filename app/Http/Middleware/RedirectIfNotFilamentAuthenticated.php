<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Filament\Http\Middleware\Authenticate as Middleware;

class RedirectIfNotFilamentAuthenticated extends Middleware
{

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    

    protected function redirectTo($request): ?string
    {
        return route('filament.auth.auth.login');
    }
}
