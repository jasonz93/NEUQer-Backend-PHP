<?php
/**
 * Created by PhpStorm.
 * User: nicholas
 * Date: 16-3-23
 * Time: 下午8:39
 */

namespace NEUQer\Facades;


use Illuminate\Support\Facades\Facade;

class TuringFacade extends Facade
{
    public static function getFacadeAccessor() {
        return 'Turing';
    }
}