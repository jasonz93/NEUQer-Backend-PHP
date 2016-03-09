<?php
/**
 * Created by PhpStorm.
 * User: nicholas
 * Date: 16-3-8
 * Time: 下午9:15
 */

namespace NEUQer\Facades;


use Illuminate\Support\Facades\Facade;

class WeixinCryptoFacade extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'WeixinCrypto';
    }
}