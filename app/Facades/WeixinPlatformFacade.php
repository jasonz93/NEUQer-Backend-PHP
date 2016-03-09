<?php
/**
 * Created by PhpStorm.
 * User: nicholas
 * Date: 16-3-8
 * Time: 下午4:13
 */

namespace NEUQer\Facades;


use Illuminate\Support\Facades\Facade;

class WeixinPlatformFacade extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'WeixinPlatformService';
    }
}