<?php

namespace App\Http\Middleware;
use Auth;
use Closure;
use Illuminate\Http\Request;
class IsAdminUtama
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
     if (Auth::user() &&  Auth::user()->status == 0) {
            return $next($request);
     }

    return redirect('/');
}
}
