<?php
/**
 * Created by PhpStorm.
 * User: nicholas
 * Date: 16-3-30
 * Time: 下午8:55
 */

namespace NEUQer\Http\Controllers\Wx3rd\Manage;


use NEUQer\Http\Controllers\Controller;
use NEUQer\Wx3rdMP;
use Response;
use Request;

class MenuController extends Controller
{
    public function getCurrent(Wx3rdMP $mp) {
        return Response::json($mp->getCurrentMenu());
    }

    public function postMenu(Wx3rdMP $mp) {
        $menu = Request::input();
        $menu = $this->removeBlanks($menu);
        error_log(print_r($menu, true));
        $mp->createCustomMenu($menu);
    }

    private function removeBlanks($menu) {
        foreach ($menu as $key => $value) {
            if (is_string($value) && strlen($value) == 0) {
                unset($menu[$key]);
            }
            if (is_array($value)) {
                $menu[$key] = $this->removeBlanks($value);
            }
        }
        return $menu;
    }
}