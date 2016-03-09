<?php

namespace NEUQer\Http\Middleware;

use Closure;
use NEUQer\WeixinOAuth;
use NEUQer\Wx3rdMP;

class WeixinOAuthMiddleware
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
        if (WeixinOAuth::check()) {
            $oauth = WeixinOAuth::getFromSession();
            \Auth::login($oauth->weixinUser->user);
            return $next($request);
        } else {
            /** @var Wx3rdMP $mp */
            $mp = \Request::route('mp');
            $params = \Route::current()->parameters();
            $params['mp'] = $mp->app_id;
            return \Response::redirectTo($mp->getOAuthUrl('snsapi_userinfo', \Route::currentRouteName(), $params));
        }
    }
}
