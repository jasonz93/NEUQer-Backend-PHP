<?php
/**
 * Created by PhpStorm.
 * User: nicholas
 * Date: 16-2-25
 * Time: 下午12:43
 */

namespace NEUQer\SDK\Weixin\Exception;


class ValidateAppIdException extends \Exception
{
    protected $code = 40005;

    public function __construct($expect, $actual)
    {
        $this->message = "Error when validating app id. Expect $expect but got $actual.";
    }
}