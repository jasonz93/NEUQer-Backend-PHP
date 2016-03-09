<?php
/**
 * Created by PhpStorm.
 * User: nicholas
 * Date: 16-2-25
 * Time: 下午12:26
 */

namespace NEUQer\SDK\Weixin;


use NEUQer\SDK\Weixin\Exception\DecryptAesException;
use NEUQer\SDK\Weixin\Exception\EncryptAesException;
use NEUQer\SDK\Weixin\Exception\IllegalBufferException;
use NEUQer\SDK\Weixin\Exception\ValidateAppIdException;

class WeixinCrypto
{
    private $key;

    public function __construct($key)
    {
        $this->key = base64_decode($key.'=');
    }

    public function encrypt($text, $app_id) {
        try {
            $random = $this->getRandomStr();
            $text = $random . pack("N", strlen($text)) . $text . $app_id;
            $size = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
            $module = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');
            $iv = substr($this->key, 0, 16);
            $pkc_encoder = new PKCS7Encoder();
            $text = $pkc_encoder->encode($text);
            mcrypt_generic_init($module, $this->key, $iv);
            $encrypted = mcrypt_generic($module, $text);
            mcrypt_generic_deinit($module);
            mcrypt_module_close($module);
            return base64_encode($encrypted);
        } catch (\Exception $e) {
            throw new EncryptAesException();
        }
    }

    public function decrypt($encrypted, $app_id) {
        try {
            $cipher_text_dec = base64_decode($encrypted);
            $module = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');
            $iv = substr($this->key, 0, 16);
            mcrypt_generic_init($module, $this->key, $iv);
            $decrypted = mdecrypt_generic($module, $cipher_text_dec);
            mcrypt_generic_deinit($module);
            mcrypt_module_close($module);
        } catch (\Exception $e) {
            throw new DecryptAesException();
        }

        try {
            $pkc_encoder = new PKCS7Encoder();
            $result = $pkc_encoder->decode($decrypted);
            if (strlen($result) < 16) {
                return "";
            }
            $content = substr($result, 16, strlen($result));
            $len_list = unpack("N", substr($content, 0, 4));
            $xml_len = $len_list[1];
            $xml_content = substr($content, 4, $xml_len);
            $from_app_id = substr($content, $xml_len + 4);
        } catch (\Exception $e) {
            throw new IllegalBufferException();
        }
        if ($from_app_id != $app_id) {
            throw new ValidateAppIdException($app_id, $from_app_id);
        }
        return $xml_content;
    }

    private function getRandomStr()
    {

        $str = "";
        $str_pol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        $max = strlen($str_pol) - 1;
        for ($i = 0; $i < 16; $i++) {
            $str .= $str_pol[mt_rand(0, $max)];
        }
        return $str;
    }
}