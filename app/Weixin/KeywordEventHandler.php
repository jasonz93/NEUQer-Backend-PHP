<?php
/**
 * Created by PhpStorm.
 * User: nicholas
 * Date: 16-3-26
 * Time: 下午1:10
 */

namespace NEUQer\Weixin;


use NEUQer\WeixinUser;

class KeywordEventHandler implements EventHandlerInterface
{
    const NAME = 'KEYWORD';

    /**
     * @param WeixinUser $weixinUser
     * @param array $xml
     * @param array $params
     * @return array
     */
    public function handle(WeixinUser $weixinUser, array $xml, array $params)
    {
        if ($xml['MsgType'] !== 'text') {
            return null;
        }
        $hit = true;
        if ($params['accurate']) {
            $hit &= $xml['Content'] === $params['keyword'];
        } else {
            $hit &= str_contains($xml['Content'], $params['keyword']);
        }
        if (!$hit) {
            return null;
        }
        return [
            'ToUserName' => $xml['FromUserName'],
            'FromUserName' => $xml['ToUserName'],
            'CreateTime' => time(),
            'MsgType' => 'text',
            'Content' => $params['content']
        ];
    }
}