<?php
/**
 * Created by PhpStorm.
 * User: nicholas
 * Date: 16-3-8
 * Time: 下午9:02
 */

namespace NEUQer\Http\Controllers\Wx3rd;


use Illuminate\Routing\Controller;
use NEUQer\WeixinUser;
use NEUQer\Wx3rdMP;
use Response;
use Request;
use WeixinCrypto;

class MPController extends Controller
{
    public function getOAuth(Wx3rdMP $mp) {
        $response = $mp->finishOAuth(Request::query('code'), Request::query('state'));
        if (is_array($response)) {
            return Response::redirectToRoute($response['route'], $response['params']);
        } else {
            return Response::json($response);
        }
    }

    public function postEvent(Wx3rdMP $mp) {
        $xml = WeixinCrypto::decryptMsg(Request::query('msg_signature'), Request::query('timestamp'), Request::query('nonce'), Request::getContent());
        \Log::info(print_r($xml, true));

        $weixinUser = WeixinUser::where('openid', '=', $xml['FromUserName'])->first();
        if ($weixinUser == null) {
            $weixinUser = new WeixinUser();
            $weixinUser->openid = $xml['FromUserName'];
            $weixinUser->mp()->associate($mp);
            if ($mp->canManageUser()) {
                $weixinUser->refreshInfo(false);
            } else {
                $weixinUser->nickname = '微信用户';
            }
            $weixinUser->createUser();
            $weixinUser->save();
        }

        $timestamp = time();
        $responseXml = "<xml>
<ToUserName><![CDATA[{$xml['FromUserName']}]]></ToUserName>
<FromUserName><![CDATA[{$xml['ToUserName']}]]></FromUserName>
<CreateTime>$timestamp</CreateTime>
<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA[你好]]></Content>
</xml>";
        $encryptedXml = $responseXml === '' ? 'success' : WeixinCrypto::encrtpyMsg($responseXml, time(), rand(10000,99999));
        return Response::make($encryptedXml, 200, [
            'Content-Type' => 'text/xml'
        ]);
    }

    public function getRefresh(Wx3rdMP $mp) {
        $mp->refreshInfo();
        return Response::json($mp);
    }
}