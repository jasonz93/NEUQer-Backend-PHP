<?php
/**
 * Created by PhpStorm.
 * User: nicholas
 * Date: 16-2-25
 * Time: 下午12:23
 */

namespace NEUQer\SDK\Weixin;


use NEUQer\SDK\Weixin\Exception\ComputeSignatureException;
use NEUQer\SDK\Weixin\Exception\IllegalAesKeyException;
use NEUQer\SDK\Weixin\Exception\ValidateSignatureErrorException;

class WXBizMsgCrtpy
{
    private $token;
    private $encoding_aes_key;
    private $app_id;

    public function __construct($token, $encoding_aes_key, $app_id)
    {
        $this->token = $token;
        $this->encoding_aes_key = $encoding_aes_key;
        $this->app_id = $app_id;
    }

    public function encrtpyMsg($reply_msg, $timestamp, $nonce) {
        $crypto = new WeixinCrypto($this->encoding_aes_key);

        if ($timestamp == null) {
            $timestamp = time();
        }
        $encrypted = $crypto->encrypt($reply_msg, $this->app_id);
        $signature = $this->getSHA1($timestamp, $nonce, $encrypted);
        $xmlParser = new XmlParser();
        return $xmlParser->generate($encrypted, $signature, $timestamp, $nonce);
    }

    public function decryptMsg($msg_signature, $timestamp, $nonce, $encryptedXml) {
        if (strlen($this->encoding_aes_key) != 43) {
            throw new IllegalAesKeyException();
        }
        $crypto = new WeixinCrypto($this->encoding_aes_key);
        $encryptedXmlArr = XmlParser::parse($encryptedXml);
        $signature = $this->getSHA1($timestamp, $nonce, $encryptedXmlArr['Encrypt']);
        if ($signature !== $msg_signature) {
            throw new ValidateSignatureErrorException($msg_signature, $signature);
        }
        $decryptedXml = $crypto->decrypt($encryptedXmlArr['Encrypt'], $this->app_id);
        return XmlParser::parse($decryptedXml);
    }

    private function getSHA1($timestamp, $nonce, $encrypt_msg) {
        try {
            $arr = [$encrypt_msg, $this->token, $timestamp, $nonce];
            sort($arr, SORT_STRING);
            $str = implode($arr);
            return sha1($str);
        } catch (\Exception $e) {
            throw new ComputeSignatureException();
        }
    }
}