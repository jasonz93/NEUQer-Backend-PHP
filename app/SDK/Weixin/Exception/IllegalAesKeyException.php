<?php
/**
 * Created by PhpStorm.
 * User: nicholas
 * Date: 16-2-25
 * Time: 下午2:18
 */

namespace NEUQer\SDK\Weixin\Exception;


class IllegalAesKeyException extends \Exception
{
    protected $code = 40004;
}