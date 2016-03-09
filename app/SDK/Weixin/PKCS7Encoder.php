<?php
/**
 * Created by PhpStorm.
 * User: nicholas
 * Date: 16-2-25
 * Time: 下午12:29
 */

namespace NEUQer\SDK\Weixin;


class PKCS7Encoder
{
    const BLOCK_SIZE = 32;

    public function encode($text) {
        $length = strlen($text);
        $amount_to_pad = self::BLOCK_SIZE - ($length % self::BLOCK_SIZE);
        if ($amount_to_pad === 0) {
            $amount_to_pad = self::BLOCK_SIZE;
        }
        $pad_chr = chr($amount_to_pad);
        $tmp = '';
        for ($i = 0; $i < $amount_to_pad; $i ++) {
            $tmp .= $pad_chr;
        }
        return $text . $tmp;
    }

    public function decode($text) {
        $pad = ord(substr($text, -1));
        if ($pad < 1 || $pad > 32) {
            $pad = 0;
        }
        return substr($text, 0, strlen($text) - $pad);
    }
}