<?php
/**
 * Created by PhpStorm.
 * User: nicholas
 * Date: 16-2-25
 * Time: 下午12:49
 */

namespace NEUQer\SDK\Weixin\Exception;


class ComputeSignatureException extends \Exception
{
    protected $code = 40003;
}