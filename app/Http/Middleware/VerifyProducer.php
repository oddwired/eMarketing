<?php

namespace Emarketing\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class VerifyProducer
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
        if(!Auth::guard("producer")->check())
            return redirect(url("producer/login"));
        return $next($request);
    }
}
