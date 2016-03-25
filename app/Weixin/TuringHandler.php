<?php
/**
 * Created by PhpStorm.
 * User: nicholas
 * Date: 16-3-23
 * Time: 下午9:47
 */

namespace NEUQer\Weixin;

use NEUQer\User;
use NEUQer\WeixinUser;
use Turing;

class TuringHandler implements EventHandlerInterface
{
    const NAME = 'TURING';

    public function handle(WeixinUser $weixinUser, array $xml, array $params) {
        if ($xml['MsgType'] === 'text') {
            $response = Turing::send($xml['Content'], $weixinUser->user->id);
            if ($response !== null) {
                if ($response['type'] === 'text') {
                    return [
                        'ToUserName' => $xml['FromUserName'],
                        'FromUserName' => $xml['ToUserName'],
                        'CreateTime' => time(),
                        'MsgType' => 'text',
                        'Content' => $response['content']
                    ];
                }
            }
        }

        return null;
    }
}