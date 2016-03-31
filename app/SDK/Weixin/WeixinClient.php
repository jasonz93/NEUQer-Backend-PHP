<?php
/**
 * Created by PhpStorm.
 * User: nicholas
 * Date: 16-2-25
 * Time: 下午12:04
 */

namespace NEUQer\SDK\Weixin;


use NEUQer\SDK\Weixin\Exception\UnknownWeixinException;

class WeixinClient
{
    const BASE_URL = 'https://api.weixin.qq.com';
    const ENDPOINT_COMPONENT_ACCESS_TOKEN = '/cgi-bin/component/api_component_token';
    const ENDPOINT_CREATE_PRE_AUTH_CODE = '/cgi-bin/component/api_create_preauthcode';
    const ENDPOINT_QUERY_AUTH = '/cgi-bin/component/api_query_auth';
    const ENDPOINT_REFRESH_AUTHORIZER_TOKEN = '/cgi-bin/component/api_authorizer_token';
    const ENDPOINT_GET_AUTHORIZER_INFO = '/cgi-bin/component/api_get_authorizer_info';
    const ENDPOINT_OAUTH_ACCESS_TOKEN = '/sns/oauth2/component/access_token';
    const ENDPOINT_REFRESH_OAUTH = '/sns/oauth2/component/refresh_token';
    const ENDPOINT_GET_USER_INFO = '/cgi-bin/user/info';
    const ENDPOINT_GET_OAUTH_USER_INFO = '/sns/userinfo';
    const ENDPOINT_SEND_TEMPLATE_MESSAGE = '/cgi-bin/message/template/send';
    const ENDPOINT_GET_CURRENT_CUSTOM_MENU = '/cgi-bin/menu/get';
    const ENDPOINT_CREATE_CUSTOM_MENU = '/cgi-bin/menu/create';

    const CURL_OPT = [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_BINARYTRANSFER => true
    ];

    public static function getComponentAccessToken($app_id, $app_secret, $verify_ticket) {
        return self::post(self::BASE_URL.self::ENDPOINT_COMPONENT_ACCESS_TOKEN, null, [
            'component_appid' => $app_id,
            'component_appsecret' => $app_secret,
            'component_verify_ticket' => $verify_ticket
        ]);
    }

    public static function createPreAuthCode($component_access_token, $component_app_id) {
        return self::post(self::BASE_URL.self::ENDPOINT_CREATE_PRE_AUTH_CODE, [
            'component_access_token' => $component_access_token
        ], [
            'component_appid' => $component_app_id
        ]);
    }

    public static function queryAuth($component_access_token, $component_app_id, $authorization_code) {
        return self::post(self::BASE_URL.self::ENDPOINT_QUERY_AUTH, [
            'component_access_token' => $component_access_token
        ], [
            'component_appid' => $component_app_id,
            'authorization_code' => $authorization_code
        ]);
    }

    public static function refreshAuthorizerToken($component_access_token, $component_app_id, $authorizer_app_id, $authorizer_refresh_token) {
        return self::post(self::BASE_URL.self::ENDPOINT_REFRESH_AUTHORIZER_TOKEN, [
            'component_access_token' => $component_access_token
        ], [
            'component_appid' => $component_app_id,
            'authorizer_appid' => $authorizer_app_id,
            'authorizer_refresh_token' => $authorizer_refresh_token
        ]);
    }

    public static function getAuthorizerInfo($component_access_token, $component_app_id, $authorizer_app_id) {
        return self::post(self::BASE_URL.self::ENDPOINT_GET_AUTHORIZER_INFO, [
            'component_access_token' => $component_access_token
        ], [
            'component_appid' => $component_app_id,
            'authorizer_appid' => $authorizer_app_id
        ]);
    }

    /**
     * {
     *      "access_token":"ACCESS_TOKEN",
     *      "expires_in":7200,
     *      "refresh_token":"REFRESH_TOKEN",
     *      "openid":"OPENID",
     *      "scope":"SCOPE"
     * }
     * @param $app_id
     * @param $code
     * @param $component_app_id
     * @param $component_access_token
     * @return array
     */
    public static function getOauthAccessToken($app_id, $code, $component_app_id, $component_access_token) {
        return self::get(self::BASE_URL.self::ENDPOINT_OAUTH_ACCESS_TOKEN, [
            'appid' => $app_id,
            'code' => $code,
            'grant_type' => 'authorization_code',
            'component_appid' => $component_app_id,
            'component_access_token' => $component_access_token
        ]);
    }

    /**
     * {
     *      "access_token":"ACCESS_TOKEN",
     *      "expires_in":7200,
     *      "refresh_token":"REFRESH_TOKEN",
     *      "openid":"OPENID",
     *      "scope":"SCOPE"
     * }
     * @param $appId
     * @param $componentAppId
     * @param $componentAccessToken
     * @param $refreshToken
     * @return array
     */
    public static function refreshOauth($appId, $componentAppId, $componentAccessToken, $refreshToken) {
        return self::get(self::BASE_URL.self::ENDPOINT_REFRESH_OAUTH, [
            'appid' => $appId,
            'grant_type' => 'refresh_token',
            'component_appid' => $componentAppId,
            'component_access_token' => $componentAccessToken,
            'refresh_token' => $refreshToken
        ]);
    }

    public static function getUserInfo($accessToken, $openId) {
        return self::get(self::BASE_URL.self::ENDPOINT_GET_USER_INFO, [
            'access_token' => $accessToken,
            'openid' => $openId,
            'lang' => 'zh_CN'
        ]);
    }

    /**
     * {
     *      "openid":" OPENID",
     *      "nickname": NICKNAME,
     *      "sex":"1",
     *      "province":"PROVINCE"
     *      "city":"CITY",
     *      "country":"COUNTRY",
     *      "headimgurl": "http://wx.qlogo.cn/mmopen/g3MonUZtNHkdmzicIlibx6iaFqAc56vxLSUfpb6n5WKSYVY0ChQKkiaJSgQ1dZuTOgvLLrhJbERQQ4eMsv84eavHiaiceqxibJxCfHe/46",
     *      "privilege":["PRIVILEGE1", "PRIVILEGE2"],
     *      "unionid": "o6_bmasdasdsad6_2sgVt7hMZOPfL"
     * }
     * @param $accessToken
     * @param $openId
     * @return array
     */
    public static function getOAuthUserInfo($accessToken, $openId) {
        return self::get(self::BASE_URL.self::ENDPOINT_GET_OAUTH_USER_INFO, [
            'access_token' => $accessToken,
            'openid' => $openId,
            'lang' => 'zh_CN'
        ]);
    }

    public static function sendTemplateMessage($accessToken, $openId, $templateId, $url, array $data) {
        return self::post(self::BASE_URL.self::ENDPOINT_SEND_TEMPLATE_MESSAGE, [
            'access_token' => $accessToken
        ], [
            'touser' => $openId,
            'template_id' => $templateId,
            'url' => $url,
            'data' => $data
        ]);
    }

    public static function getCurrentCustomMenu($accessToken) {
        return self::get(self::BASE_URL.self::ENDPOINT_GET_CURRENT_CUSTOM_MENU, ['access_token' => $accessToken]);
    }

    public static function createCustomMenu($accessToken, $menu) {
        return self::post(self::BASE_URL.self::ENDPOINT_CREATE_CUSTOM_MENU, [
            'access_token' => $accessToken
        ], $menu);
    }

    private static function post($url, $query, $body) {
        if ($query != null) {
            $url .= '?'.http_build_query($query);
        }
        $ch = curl_init();
        $opt = [
            CURLOPT_URL => $url,
            CURLOPT_CUSTOMREQUEST => 'POST'
        ];
        curl_setopt_array($ch, self::CURL_OPT);
        curl_setopt_array($ch, $opt);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body, JSON_UNESCAPED_UNICODE));
        return self::execute($ch);
    }

    private static function get($url, $query) {
        if ($query != null) {
            $url .= '?'.http_build_query($query);
        }
        $ch = curl_init();
        $opt = [
            CURLOPT_URL => $url,
            CURLOPT_CUSTOMREQUEST => 'GET'
        ];
        curl_setopt_array($ch, self::CURL_OPT);
        curl_setopt_array($ch, $opt);
        return self::execute($ch);
    }

    private static function execute(&$ch) {
        $result = json_decode(curl_exec($ch), true);
        curl_close($ch);
        if (isset($result['errcode']) && $result['errcode'] !== 0) {
            throw new UnknownWeixinException($result);
        }
        return $result;
    }
}