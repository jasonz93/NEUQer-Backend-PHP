<?php
/**
 * Created by PhpStorm.
 * User: nicholas
 * Date: 16-2-25
 * Time: 下午10:16
 */

namespace NEUQer\SDK\CET;


use NEUQer\SDK\CET\Exception\UnknownCETException;
use NEUQer\SDK\CET\Exception\IllegalAdmissionException;

class CET99susheClient extends AbstractCETClient
{
    const URL = 'http://cet.99sushe.com/findscore';
    const CURL_OPT = [
        CURLOPT_URL => self::URL,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_REFERER => 'http://cet.99sushe.com/',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_BINARYTRANSFER => true
    ];

    public function getScore($admission, $name)
    {
        $ch = curl_init();
        curl_setopt_array($ch, self::CURL_OPT);
        $nameGBK = rawurlencode(mb_convert_encoding($name, 'gb2312', 'utf8'));
        $body = "id=$admission&name=$nameGBK";
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/x-www-form-urlencoded'
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        $result = curl_exec($ch);
        //TODO: handle connection error
        $err = curl_errno($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($err != 0 || $status != 200) {
            $ex = new UnknownCETException();
            $ex->curlCode = $err;
            $ex->httpStatus = $status;
            throw $ex;
        }
        curl_close($ch);
        mb_convert_variables('utf8', 'gb2312', $result);
        if ($result == '1') {
            $ex = new UnknownCETException();
            $ex->response = $result;
            throw $ex;
        }
        if ($result == '4') {
            throw new IllegalAdmissionException;
        }
        $arr = explode(',', $result);
        $result = [
            'listen' => $arr[1],
            'read' => $arr[2],
            'write' => $arr[3],
            'total' => $arr[4],
            'school' => $arr[5],
            'name' => $arr[6],
            'type' => self::getTypeFromAdmission($admission)
        ];
        return $result;
    }
}