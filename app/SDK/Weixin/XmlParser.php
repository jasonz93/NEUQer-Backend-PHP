<?php
/**
 * Created by PhpStorm.
 * User: nicholas
 * Date: 16-2-25
 * Time: 下午12:50
 */

namespace NEUQer\SDK\Weixin;


use NEUQer\SDK\Weixin\Exception\ParseXmlException;
use NEUQer\Slim\App;

class XmlParser
{
    public static function parse($xmlText) {
        $xml = simplexml_load_string($xmlText);
        return self::convert($xml);
    }

    private static function convert(\SimpleXMLElement $xml) {
        if ($xml->count() == 0) {
            return strval($xml);
        } else {
            $output = [];
            foreach ($xml as $name => $element) {
                $output[$name] = self::convert($element);
            }
            return $output;
        }
    }

    public function generate($encrypted, $signature, $timestamp, $nonce) {
        $format = "<xml><Encrypt><![CDATA[%s]]></Encrypt><MsgSignature><![CDATA[%s]]></MsgSignature><TimeStamp>%s</TimeStamp><Nonce>%s</Nonce></xml>";
        return sprintf($format, $encrypted, $signature, $timestamp, $nonce);
    }
}