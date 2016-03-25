<?php
/**
 * Created by PhpStorm.
 * User: nicholas
 * Date: 16-3-24
 * Time: 下午1:53
 */

namespace NEUQer\Http\Controllers\Admin;


use NEUQer\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function getIndex() {
        return view('admin.index');
    }
}