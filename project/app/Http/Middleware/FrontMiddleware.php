<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use TorMorten\Eventy\Facades\Events as Eventy;

class FrontMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(get_option('maintenance_status')){
            return redirect(url('maintenance'));
        }
        else {
            return $next($request);
        }
        
    }
}