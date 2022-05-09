<?php

namespace App\Http\Middleware;

use Closure;

class VerifyUser
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
        if(!empty($request->session()->get("username")) && !empty($request->session()->get("user_id")))
        {
            return $next($request);
        }
        else
        {
            return redirect()->route("userLoginRoute");
        }
    }
}
