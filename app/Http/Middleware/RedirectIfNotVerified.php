<?php

namespace App\Http\Middleware;

use Closure;

class RedirectIfNotVerified
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
        if( !auth()->user()->is_verified ){
            return redirect('/home')->with('error', 'Please wait while we verify your account');
        }
        return $next($request);
    }
}
