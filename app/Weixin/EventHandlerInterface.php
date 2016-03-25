<?php
/**
 * Created by PhpStorm.
 * User: nicholas
 * Date: 16-3-23
 * Time: 下午9:45
 */

namespace NEUQer\Weixin;


use NEUQer\WeixinUser;

interface EventHandlerInterface
{
    /**
     * @param WeixinUser $weixinUser
     * @param array $xml
     * @param array $params
     * @return array
     */
    public function handle(WeixinUser $weixinUser, array $xml, array $params);
}