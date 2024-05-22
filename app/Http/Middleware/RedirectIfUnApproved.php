<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfUnApproved
{

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $profile_url = route('filament.admin.pages.my-profile');
        
        if (auth()->check()) {
            if (!(bool) auth()->user()->approved && !in_array(($request->segment(1)), ['my-profile', 'logout'])) {
                abort(405, 'Registration Pending Approval.<br/> <a class="underline" href="' . $profile_url . '" style="">Go to Profile</a>');
            }
        }
        return $next($request);
    }
}
