<?php
/**
 * Created by PhpStorm.
 * User: nicholas
 * Date: 16-3-8
 * Time: 下午4:51
 */

namespace NEUQer\Facades;


use Illuminate\Support\Facades\Facade;

class UtilsFacade extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'UtilService';
    }
}