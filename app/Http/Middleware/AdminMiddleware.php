<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Redirect;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            if (Auth::user()->user_type != '1') {
                Auth::logout();
                return Redirect::to('login')->withErrors('success', 'You are not the system admin!');
            }
        } else {
            return Redirect::to('login')->withErrors('Please login');
        }
        return $next($request);
    }
}
