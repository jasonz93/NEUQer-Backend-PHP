<?php

namespace NEUQer\Http\Middleware;

use Closure;
use Request;
use Auth;

class Wx3rdMPManageMiddleware
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
        $user = Auth::user();
        $mp = Request::route('mp');
        if (policy($mp)->owns($user, $mp)) {
            return $next($request);
        } else {
            return response('Forbidden.', 403);
        }
    }
}
