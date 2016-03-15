<?php
/**
 * Created by PhpStorm.
 * User: nicholas
 * Date: 16-3-12
 * Time: 下午9:02
 */

namespace NEUQer\Http\Controllers\REST;


use NEUQer\Http\Controllers\Controller;
use NEUQer\User;
use NEUQer\UserToken;
use Request;

class AuthController extends Controller
{
    public function postAuth() {
        $mobile = Request::input('mobile');
        $password = Request::input('password');
        $user = User::whereMobile($mobile)->wherePassword($password)->first();
        if ($user === null) {
            abort(403);
            return;
        }
        $token = UserToken::createByUser($user, 'mobile');
        return \Response::json([
            'user' => $user,
            'token' => $token->token
        ]);
    }

    public function getUser() {
        return \Response::json(\Auth::guard('api')->user());
    }
}