<?php

namespace NEUQer;

use Illuminate\Database\Eloquent\Model;
use NEUQer\SDK\Weixin\WeixinClient;

class WeixinUser extends Model
{
    public function user() {
        return $this->belongsTo('NEUQer\User');
    }

    public function mp() {
        return $this->belongsTo('NEUQer\Wx3rdMP');
    }

    public function refreshInfo($autosave = true) {
        $info = WeixinClient::getUserInfo($this->mp->getAccessToken(), $this->openid);
        if ($info['subscribe'] === 0) {
            return false;
        }
        $this->unionid = $info['unionid'];
        $this->nickname = $info['nickname'];
        $this->avatar = $info['headimgurl'];
        if ($autosave) {
            $this->save();
        }
    }

    public function createUser() {
        $user = User::create([
            'email' => null,
            'mobile' => null,
            'nickname' => $this->nickname,
            'password' => bcrypt($this->openid)
        ]);
        $this->user()->associate($user);
    }

    public function sendTemplateMessage($url, $templateId, $data) {
        WeixinClient::sendTemplateMessage($this->mp->getAccessToken(), $this->openid, $templateId, $url, $data);
    }
}
