<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ModeratorMiddleware
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
        if (Auth::check() && Auth::user()->role_id == 2 && Auth::user()->status == 1) {
            return $next($request);
        }

        if (Auth::check() && Auth::user()->role_id == 1) {
            return redirect()->route('admin.index');
        }

        if (Auth::check() && Auth::user()->role_id == 3 && Auth::user()->status == 1) {
            return redirect()->route('author.index');
        }

        return redirect()->route('login');
    }
}
