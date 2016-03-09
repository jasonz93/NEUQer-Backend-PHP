<?php
/**
 * Created by PhpStorm.
 * User: nicholas
 * Date: 16-3-8
 * Time: 下午4:50
 */

namespace NEUQer\Services;


class UtilService
{
    public function microtimestamp() {
        list($usec, $sec) = explode(' ', microtime());
        return (int)($sec * 1000 + $usec * 1000);
    }
}