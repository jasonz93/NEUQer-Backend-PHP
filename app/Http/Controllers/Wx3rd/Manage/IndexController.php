<?php
/**
 * Created by PhpStorm.
 * User: nicholas
 * Date: 16-3-24
 * Time: 下午8:46
 */

namespace NEUQer\Http\Controllers\Wx3rd\Manage;


use NEUQer\Http\Controllers\Controller;
use NEUQer\Wx3rdMP;
use Response;

class IndexController extends Controller
{
    public function getInfo(Wx3rdMP $mp) {
        return Response::json($mp);
    }

    public function getRefresh(Wx3rdMP $mp) {
        $mp->refreshInfo();
    }


}