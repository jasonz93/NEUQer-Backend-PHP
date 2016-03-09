<?php
/**
 * Created by PhpStorm.
 * User: nicholas
 * Date: 16-2-25
 * Time: 下午2:20
 */

namespace NEUQer\SDK\Weixin\Exception;


class ValidateSignatureErrorException extends \Exception
{
    protected $code = 40001;

    public function __construct($expect, $actual) {
        $this->message = "Error when validating signature. Expect $expect but got $actual .";
    }
}