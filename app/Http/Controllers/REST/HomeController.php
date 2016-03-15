<?php
/**
 * Created by PhpStorm.
 * User: nicholas
 * Date: 16-3-15
 * Time: 下午9:15
 */

namespace NEUQer\Http\Controllers\REST;


use NEUQer\HomeMessage;
use NEUQer\Http\Controllers\Controller;
use Response;
use Request;

class HomeController extends Controller
{
    public function getHome() {
        return Response::json([
            'banners' => HomeMessage::getBanners(),
            'lists' => HomeMessage::getLists()
        ]);
    }

    public function getHistory() {
        $per = Request::query('per', 20);
        $page = Request::query('page', 1);
        return Response::json(HomeMessage::getHistory($per, $page));
    }
}