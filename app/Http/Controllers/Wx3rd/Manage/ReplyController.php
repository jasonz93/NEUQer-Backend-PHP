<?php
/**
 * Created by PhpStorm.
 * User: nicholas
 * Date: 16-3-25
 * Time: 下午8:47
 */

namespace NEUQer\Http\Controllers\Wx3rd\Manage;


use NEUQer\Http\Controllers\Controller;
use NEUQer\WeixinEventHandler;
use NEUQer\Wx3rdMP;
use Request;
use Response;

class ReplyController extends Controller
{
    public function getIndex(Wx3rdMP $mp) {
        return view('wx3rd.manage.reply', ['mp' => $mp]);
    }

    public function getHandlers(Wx3rdMP $mp) {
        $handlers = WeixinEventHandler::whereMpAppId($mp->app_id)
            ->where('priority', '>=', 0)
            ->orderBy('priority')
            ->get();
        return Response::json($handlers);
    }

    public function createHandler(Wx3rdMP $mp) {
        $handler = new WeixinEventHandler();
        $handler->mp()->associate($mp);
        $handler->name = Request::input('name');
        $handler->params = Request::input('params', []);
        $handler->priority = Request::input('priority', 0);
        $handler->saveOrFail();
    }

    public function updateHandler(Wx3rdMP $mp, WeixinEventHandler $eventHandler) {
        $eventHandler->priority = Request::input('priority', 0);
        $eventHandler->params = Request::input('params', []);
        $eventHandler->saveOrFail();
    }

    public function deleteHandler(Wx3rdMP $mp, WeixinEventHandler $eventHandler) {
        $eventHandler->delete();
    }
}