<?php

namespace App\Http\Middleware;

use Closure;
use App\Permission;

class RegisterPermissionMiddleware
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
        $register = Permission::first();
        if ($register->register == 1) {
            return $next($request);
        }
        return redirect()->route('login');
    }
}
