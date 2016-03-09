<?php
/**
 * Created by PhpStorm.
 * User: nicholas
 * Date: 16-2-26
 * Time: 上午2:45
 */

namespace NEUQer\SDK\Weixin\Exception;


class UnknownWeixinException extends \Exception
{
    public function __construct($arr)
    {
        $this->message = json_encode($arr, JSON_PRETTY_PRINT);
    }
}