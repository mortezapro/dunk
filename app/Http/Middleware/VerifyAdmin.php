<?php

namespace App\Http\Middleware;

use Closure;

class VerifyAdmin
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
        if(!empty($request->session()->get("admin_username")) && !empty($request->session()->get("admin_user_id")) && !empty($request->session()->get("admin_user_mobile")))
        {
            return $next($request);
        }
        else
        {
            return redirect()->route("indexRoute");
        }
    }
}
