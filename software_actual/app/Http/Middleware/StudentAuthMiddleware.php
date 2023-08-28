<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
class StudentAuthMiddleware
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
        if (Auth::guard('student')->check()) {
            return $next($request);
        }
        if(isset(Auth::user()->role) && (Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin')){
            return $next($request);
        }

        return redirect('/student/login');
    }
}
