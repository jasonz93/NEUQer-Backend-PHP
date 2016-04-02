<?php
/**
 * Created by PhpStorm.
 * User: nicholas
 * Date: 16-3-8
 * Time: 下午4:03
 */

namespace NEUQer\Services;


use NEUQer\KV;
use NEUQer\SDK\Weixin\WeixinClient;
use NEUQer\SDK\Weixin\WXBizMsgCrtpy;
use NEUQer\SDK\Weixin\XmlParser;
use Log;
use NEUQer\User;
use NEUQer\Wx3rdMP;
use Utils;
use Route;

class WeixinPlatformService
{
    public function handleAuthorizationPush($signature, $timestamp, $nonce, $payload) {
        $crypto = new WXBizMsgCrtpy(env('WX3RD_TOKEN'), env('WX3RD_ENCODING_AES_KEY'), env('WX3RD_APP_ID'));
        try {
            $xml = $crypto->decryptMsg($signature, $timestamp, $nonce, $payload);
            switch ($xml['InfoType']) {
                case 'component_verify_ticket':
                    KV::updateOrCreate([
                        'key' => 'COMPONENT_VERIFY_TICKET'
                    ], [
                        'value' => $xml['ComponentVerifyTicket']
                    ]);
                    Log::info('Verify Ticket updated: '.$xml['ComponentVerifyTicket']);
                    break;
                default:
                    Log::error('Received an authorization push of unknown type: '.$xml['InfoType']);
                    break;
            }
        } catch (\Exception $e) {
            Log::error('Error when decrypting authorization push, maybe not for this platform?');
            Log::error('Exception: '.get_class($e));
            Log::error('Code: '.$e->getCode());
            Log::error('Message: '.$e->getMessage());
            Log::error('Trace: '.$e->getTraceAsString());
        }

    }

    public function generateAuthorizationUrl() {
        $redirect = urlencode(route('wx3rd.authorize.callback'));
        $appId = env('WX3RD_APP_ID');
        $preAuthCode = WeixinClient::createPreAuthCode($this->getComponentAccessToken(), $appId)['pre_auth_code'];
        return "https://mp.weixin.qq.com/cgi-bin/componentloginpage?component_appid=$appId&pre_auth_code=$preAuthCode&redirect_uri=$redirect";
    }

    public function finishAuthorization(User $user, $authCode) {
        $result = WeixinClient::queryAuth($this->getComponentAccessToken(), env('WX3RD_APP_ID'), $authCode);
        $mp = Wx3rdMP::find($result['authorization_info']['authorizer_appid']);
        if ($mp == null) {
            $mp = new Wx3rdMP();
            $mp->user()->associate($user);
        }
        $mp->app_id = $result['authorization_info']['authorizer_appid'];
        $mp->access_token = $result['authorization_info']['authorizer_access_token'];
        $mp->expires_at = Utils::microtimestamp() + $result['authorization_info']['expires_in'] * 1000;
        $mp->refresh_token = $result['authorization_info']['authorizer_refresh_token'];
        $info = WeixinClient::getAuthorizerInfo($this->getComponentAccessToken(), env('WX3RD_APP_ID'), $result['authorization_info']['authorizer_appid']);
        $mp->fillWithAuthorizerInfo($info);
        $mp->save();
        return $mp;
    }

    public function getComponentAccessToken() {
        $expiresAt = KV::find('COMPONENT_ACCESS_TOKEN_EXPIRES_AT');
        if ($expiresAt === null) {
            $expiresAt = 0;
        } else {
            $expiresAt = intval($expiresAt->value);
        }
        $verifyTicket = KV::findOrFail('COMPONENT_VERIFY_TICKET')->value;
        if ($expiresAt < Utils::microtimestamp() + 300000) {
            $result = WeixinClient::getComponentAccessToken(env('WX3RD_APP_ID'), env('WX3RD_APP_SECRET'), $verifyTicket);
            $componentAccessToken = KV::updateOrCreate([
                'key' => 'COMPONENT_ACCESS_TOKEN'
            ], [
                'value' => $result['component_access_token']
            ])->value;
            KV::updateOrCreate([
                'key' => 'COMPONENT_ACCESS_TOKEN_EXPIRES_AT'
            ], [
                'value' => Utils::microtimestamp() + $result['expires_in'] * 1000
            ]);
        } else {
            $componentAccessToken = KV::findOrFail('COMPONENT_ACCESS_TOKEN')->value;
        }
        return $componentAccessToken;
    }
}