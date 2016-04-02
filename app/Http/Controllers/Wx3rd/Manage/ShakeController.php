<?php
/**
 * Created by PhpStorm.
 * User: nicholas
 * Date: 16-3-31
 * Time: 下午9:58
 */

namespace NEUQer\Http\Controllers\Wx3rd\Manage;


use NEUQer\Http\Controllers\Controller;
use NEUQer\Wx3rdMP;
use Response;

class ShakeController extends Controller
{
    public function getAudit(Wx3rdMP $mp) {
        return Response::json($mp->getShakeAuditStatus());
    }
}