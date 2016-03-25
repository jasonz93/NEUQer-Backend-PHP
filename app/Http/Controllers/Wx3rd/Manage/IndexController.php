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
    public function getIndex(Wx3rdMP $mp) {
        return view('wx3rd.manage.index', [
            'mp' => $mp
        ]);
    }

    public function getRefresh(Wx3rdMP $mp) {
        $mp->refreshInfo();
        return Response::redirectToRoute('wx3rd.mp.manage', [
            'mp' => $mp->app_id
        ]);
    }
}