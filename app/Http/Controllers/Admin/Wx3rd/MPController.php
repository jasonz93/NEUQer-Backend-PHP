<?php
/**
 * Created by PhpStorm.
 * User: nicholas
 * Date: 16-3-24
 * Time: 下午2:21
 */

namespace NEUQer\Http\Controllers\Admin\Wx3rd;


use NEUQer\Http\Controllers\Controller;
use NEUQer\Wx3rdMP;
use Response;

class MPController extends Controller
{
    public function getList() {
        $mps = Wx3rdMP::paginate(20);
        return view('admin.wx3rd.mp.list', [
            'page' => $mps
        ]);
    }

    public function getInfo(Wx3rdMP $mp) {
        return view('admin.wx3rd.mp.info', [
            'mp' => $mp
        ]);
    }

    public function getRefresh(Wx3rdMP $mp) {
        $mp->refreshInfo();
        return Response::redirectToRoute('admin.wx3rd.mp.info', [
            'mp' => $mp->app_id
        ]);
    }
}