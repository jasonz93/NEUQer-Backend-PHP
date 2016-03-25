<?php
/**
 * Created by PhpStorm.
 * User: nicholas
 * Date: 16-3-8
 * Time: 下午3:14
 */

namespace NEUQer\Http\Controllers\Wx3rd;


use Illuminate\Routing\Controller;
use NEUQer\WeixinUser;
use NEUQer\Wx3rdMP;
use Response;
use WeixinPlatform;
use Request;
use Session;
use Auth;

class Wx3rdController extends Controller
{
    public function handleAuthorizationPush() {
        WeixinPlatform::handleAuthorizationPush(
            Request::query('msg_signature'),
            Request::query('timestamp'),
            Request::query('nonce'),
            Request::getContent());
        return Response::make('success');
    }

    public function showAuthorize() {
        return Response::redirectTo(WeixinPlatform::generateAuthorizationUrl());
    }

    public function showAuthorizeCallback() {
        $mp = WeixinPlatform::finishAuthorization(Auth::user(), Request::query('auth_code'));
        return Response::json($mp);
    }

    public function getIndex() {
        $mps = Wx3rdMP::whereUserId(Auth::user()->id)->get();
        return view('wx3rd.index', [
            'mps' => $mps
        ]);
    }
}