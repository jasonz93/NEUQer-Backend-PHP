<?php

namespace NEUQer;

use Illuminate\Database\Eloquent\Model;
use NEUQer\SDK\Weixin\WeixinClient;
use Session;

class WeixinOAuth extends Model
{
    protected $table = 'weixin_oauth';
    protected $primaryKey = 'weixin_user_id';
    public $incrementing = false;

    protected $hidden = [
        'access_token',
        'refresh_token',
        'expires_at'
    ];

    public function weixinUser() {
        return $this->belongsTo('NEUQer\WeixinUser','weixin_user_id','id');
    }

    public function isExpired() {
        return $this->expires_at < \Utils::microtimestamp() + 300000;
    }

    public function getAccessToken() {
        if ($this->isExpired()) {
            /** @var Wx3rdMP $mp */
            $mp = $this->weixinUser->mp;
            $result = WeixinClient::refreshOauth($mp->app_id, env('WX3RD_APP_ID'), \WeixinPlatform::getComponentAccessToken(), $this->refresh_token);
            $this->access_token = $result['access_token'];
            $this->refresh_token = $result['refresh_token'];
            $this->expires_at = \Utils::microtimestamp() + $result['expires_in'] * 1000;
            $this->save();
        }
        return $this->access_token;
    }

    public static function check() {
        return Session::get('WeixinOAuth.id') != null && Session::get('WeixinOAuth.scope') != null;
    }

    /**
     * @return WeixinOAuth
     */
    public static function getFromSession() {
        $id = Session::get('WeixinOAuth.id');
        $scope = Session::get('WeixinOAuth.scope');
        if ($id == null || $scope == null) {
            return null;
        }
        return self::where('weixin_user_id', '=', $id)->where('scope', '=', $scope)->first();
    }
}
