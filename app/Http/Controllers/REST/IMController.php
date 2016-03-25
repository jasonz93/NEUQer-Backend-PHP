<?php
/**
 * Created by PhpStorm.
 * User: nicholas
 * Date: 16-3-23
 * Time: 下午1:40
 */

namespace NEUQer\Http\Controllers\REST;


use NEUQer\Http\Controllers\Controller;
use NEUQer\User;
use Response;

class IMController extends Controller
{
    public function getNeuqer() {
        return Response::json([
            'neuqerId' => '3365'
        ]);
    }

    public function getFriends() {
        return Response::json(User::whereId(3365)->get());
    }
}