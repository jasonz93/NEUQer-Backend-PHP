<?php

namespace NEUQer;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use NEUQer\SDK\Weixin\WeixinClient;
use Session;

class Wx3rdMP extends Model
{
    const FUNC_MSG_AND_MENU = 1;
    const FUNC_USER_MANAGE = 2;
    const FUNC_ACCOUNT_MANAGE = 3;
    const FUNC_PAGE_DEVEL = 4;
    const FUNC_SHOP = 5;
    const FUNC_MULTI_CUSTOM = 6;
    const FUNC_NOTIFY = 7;
    const FUNC_CARD = 8;
    const FUNC_SCAN = 9;
    const FUNC_WIFI = 10;
    const FUNC_MATERIAL_MANAGE = 11;
    const FUNC_SHAKE = 12;
    const FUNC_OFFLINE_SHOP = 13;

    const SERVICE_TYPE_SUBSCRIBE = 0;
    const SERVICE_TYPE_OLD_SUBSCRIBE = 1;
    const SERVICE_TYPE_SERVICE = 2;

    const VERIFY_TYPE_UNVERIFIED = -1;
    const VERIFY_TYPE_WEIXIN = 0;
    const VERIFY_TYPE_WEIBO_SINA = 1;
    const VERIFY_TYPE_WEIBO_TENCENT = 2;
    const VERIFY_TYPE_APTITUDE_WITHOUT_NAME = 3;
    const VERIFY_TYPE_APTITUDE_AND_WEIBO_SINA_WITHOUT_NAME = 4;
    const VERIFY_TYPE_APTITUDE_AND_WEIBO_TENCENT_WITHOUT_NAME = 5;

    protected $table = 'wx3rd_mps';
    protected $primaryKey = 'app_id';
    public $incrementing = false;

    protected $hidden = [
        'access_token',
        'refresh_token',
        'expires_at'
    ];

    public function user() {
        return $this->belongsTo('NEUQer\User');
    }

    public function isAccessTokenExpired() {
        return $this->expires_at < \Utils::microtimestamp() + 300000;
    }

    public function getAccessToken() {
        if ($this->isAccessTokenExpired()) {
            $componentAccessToken = \WeixinPlatform::getComponentAccessToken();
            $result = WeixinClient::refreshAuthorizerToken(
                $componentAccessToken,
                env('WX3RD_APP_ID'),
                $this->app_id,
                $this->refresh_token);
            $this->access_token = $result['authorizer_access_token'];
            $this->refresh_token = $result['authorizer_refresh_token'];
            $this->expires_at = \Utils::microtimestamp() + $result['expires_in'] * 1000;
            $this->save();
        }
        return $this->access_token;
    }

    public function refreshInfo() {
        $info = WeixinClient::getAuthorizerInfo(\WeixinPlatform::getComponentAccessToken(), env('WX3RD_APP_ID'), $this->app_id);
        $this->fillWithAuthorizerInfo($info);
        $this->save();
        return $this;
    }

    public function fillWithAuthorizerInfo($authorizerInfo) {
        $this->nickname = $authorizerInfo['authorizer_info']['nick_name'];
        $this->avatar = $authorizerInfo['authorizer_info']['head_img'];
        $this->username = $authorizerInfo['authorizer_info']['user_name'];
        $this->alias = $authorizerInfo['authorizer_info']['alias'];
        $this->qrcode_url = $authorizerInfo['authorizer_info']['qrcode_url'];
        $this->service_type = $authorizerInfo['authorizer_info']['service_type_info']['id'];
        $this->verify_type = $authorizerInfo['authorizer_info']['verify_type_info']['id'];
        $this->open_store = $authorizerInfo['authorizer_info']['business_info']['open_store'];
        $this->open_scan = $authorizerInfo['authorizer_info']['business_info']['open_scan'];
        $this->open_pay = $authorizerInfo['authorizer_info']['business_info']['open_pay'];
        $this->open_card = $authorizerInfo['authorizer_info']['business_info']['open_card'];
        $this->open_shake = $authorizerInfo['authorizer_info']['business_info']['open_shake'];
        $funcInfos = [];
        foreach ($authorizerInfo['authorization_info']['func_info'] as $funcInfo) {
            $funcInfos[] = $funcInfo['funcscope_category']['id'];
        }
        $this->setFuncInfos($funcInfos);
    }

    /**
     * @return array
     */
    public function getFuncInfos() {
        return json_decode($this->func_infos, true);
    }

    public function setFuncInfos(array $funcInfos) {
        $this->func_infos = json_encode($funcInfos);
    }

    public function getOAuthUrl($scope, $redirectRoute = '', $routeParams = []) {
        $redirectUrl = urlencode(route('wx3rd.mp.oauth', [
            'app_id' => $this->app_id
        ]));
        $state = $this->encodeRouteState($redirectRoute, $routeParams);
        $componentAppId = env('WX3RD_APP_ID');
        return "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$this->app_id}&redirect_uri=$redirectUrl&response_type=code&scope=$scope&state=$state&component_appid=$componentAppId#wechat_redirect";
    }

    private function encodeRouteState($routeName, $routeParams) {
        $str = "$routeName#";
        $paramArr = [];
        foreach ($routeParams as $k => $v) {
            $paramArr[] = "$k=$v";
        }
        $paramStr = join('&', $paramArr);
        $result = urlencode($str.$paramStr);
        return $result;
    }

    private function decodeRouteState($state) {
        $state = urldecode($state);
        list($routeName, $paramStr) = explode('#', $state);
        $paramArr = explode('&', $paramStr);
        $params = [];
        foreach ($paramArr as $param) {
            list($k, $v) = explode('=', $param);
            $params[$k] = $v;
        }
        return [
            'route' => $routeName,
            'params' => $params
        ];
    }

    /**
     * @param $code
     * @param $state
     * @return array|WeixinOAuth
     */
    public function finishOAuth($code, $state) {
        $componentAccessToken = \WeixinPlatform::getComponentAccessToken();
        $result = WeixinClient::getOauthAccessToken($this->app_id, $code, env('WX3RD_APP_ID'), $componentAccessToken);
        $oauth = WeixinOAuth::whereHas('weixinUser', function (Builder $query) use ($result) {
            $query->where('openid', '=', $result['openid'])->where('scope', '=', $result['scope']);
        })->first();
        if ($oauth == null) {
            $oauth = new WeixinOAuth();
            $weixinUser = WeixinUser::where('openid', '=', $result['openid'])->where('mp_id', '=', $this->app_id)->first();
            //TODO: unscribed user does not have entity in database
            $oauth->weixinUser()->associate($weixinUser);
            $oauth->scope = $result['scope'];
        }
        $oauth->access_token = $result['access_token'];
        $oauth->refresh_token = $result['refresh_token'];
        $oauth->expires_at = \Utils::microtimestamp() + $result['expires_in'] * 1000;
        $oauth->save();
        Session::set('WeixinOAuth.id', $oauth->weixinUser->id);
        Session::set('WeixinOAuth.scope', $oauth->scope);
        $redirect = $this->decodeRouteState($state);
        if ($redirect['route'] !== '') {
            return $redirect;
        }
        return $oauth;
    }

    public function hasFunc($func_id) {
        return in_array($func_id, $this->getFuncInfos());
    }

    public function canSetMenu() {
        return $this->hasFunc(self::FUNC_MSG_AND_MENU) && $this->service_type == self::SERVICE_TYPE_SERVICE && $this->verify_type == self::VERIFY_TYPE_WEIXIN;
    }

    public function canManageMaterial() {
        return $this->hasFunc(self::FUNC_MATERIAL_MANAGE) && $this->verify_type == self::VERIFY_TYPE_WEIXIN;
    }

    public function canSetReply() {
        return $this->hasFunc(self::FUNC_MSG_AND_MENU);
    }

    public function canPageAuth() {
        return $this->hasFunc(self::FUNC_PAGE_DEVEL) && $this->service_type == self::SERVICE_TYPE_SERVICE && $this->verify_type == self::VERIFY_TYPE_WEIXIN;
    }

    public function canSendNotify() {
        return $this->hasFunc(self::FUNC_NOTIFY) && $this->service_type == self::SERVICE_TYPE_SERVICE && $this->verify_type == self::VERIFY_TYPE_WEIXIN;
    }

    public function canManageUser() {
        return $this->hasFunc(self::FUNC_USER_MANAGE) && $this->verify_type == self::VERIFY_TYPE_WEIXIN;
    }
}
