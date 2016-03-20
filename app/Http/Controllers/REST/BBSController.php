<?php
/**
 * Created by PhpStorm.
 * User: nicholas
 * Date: 16-3-20
 * Time: 下午5:06
 */

namespace NEUQer\Http\Controllers\REST;


use NEUQer\BBSBoard;
use NEUQer\BBSTopic;
use NEUQer\Http\Controllers\Controller;
use Request;
use Response;

class BBSController extends Controller
{
    public function getTags() {
        $tags = BBSBoard::all();
        return Response::json($tags);
    }

    public function getTopics() {
        $per = Request::query('per', 20);
        $page = Request::query('page', 1);
        $topics = BBSTopic::getLatest($per, $page);
        return Response::json($topics);
    }
}