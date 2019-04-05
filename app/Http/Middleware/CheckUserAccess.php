<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use \Kamaln7\Toastr\Facades\Toastr;

class CheckUserAccess
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
        if (!Auth::user() or Auth::user()->email_verified_at == null ) 
        {
            // msg
            return redirect(route('showLogin'));
        
		}

        return $next($request);
    }
}