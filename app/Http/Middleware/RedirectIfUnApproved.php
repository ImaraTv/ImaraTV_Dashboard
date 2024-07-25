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
            if (auth()->user()->hasRole('user')) {
                session()->flush();
                session()->regenerate(true);
                auth()->logout();
                return redirect()->to(env('APP_LIVE_URL'));
            }
            if (!(bool) auth()->user()->approved && !in_array(($request->segment(1)), ['my-profile', 'logout','email-verification'])) {
                return redirect()->to($profile_url);
            }
        }
        return $next($request);
    }
}
