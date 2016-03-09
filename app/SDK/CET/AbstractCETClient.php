<?php
/**
 * Created by PhpStorm.
 * User: nicholas
 * Date: 16-2-25
 * Time: 下午10:15
 */

namespace NEUQer\SDK\CET;


abstract class AbstractCETClient
{
    public abstract function getScore($admission, $name);

    public static function getTypeFromAdmission($admission) {
        $type = substr($admission, 9, 1);
        switch ($type) {
            case '1':
                return '英语四级';
            case '2':
                return '英语六级';
            case '3':
                return '日语四级';
            case '4':
                return '日语六级';
            case '5':
                return '德语四级';
            case '6':
                return '德语六级';
            case '7':
                return '俄语四级';
            case '8':
                return '俄语六级';
            case '9':
                return '法语四级';
            default:
                return "未知类型$type";
        }
    }
}