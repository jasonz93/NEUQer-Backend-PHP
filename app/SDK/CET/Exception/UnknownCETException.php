<?php
/**
 * Created by PhpStorm.
 * User: nicholas
 * Date: 16-2-25
 * Time: 下午10:20
 */

namespace NEUQer\SDK\CET\Exception;


class UnknownCETException extends \Exception
{
    //TODO: code
    protected $message = '发生了一些奇怪的错误，程序猿童鞋正在紧张修复呢～';


    public $curlCode;

    public $httpStatus;

    public $response;

    public function __toString()
    {
        return get_called_class() . ": CURL: $this->curlCode, HTTP: $this->httpStatus, Response: $this->response";
    }
}