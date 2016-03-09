<?php
/**
 * Created by PhpStorm.
 * User: nicholas
 * Date: 16-3-8
 * Time: 下午9:13
 */

namespace NEUQer\Providers;


use Illuminate\Support\ServiceProvider;
use NEUQer\SDK\Weixin\WXBizMsgCrtpy;

class WeixinCryptoProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('WeixinCrypto', function () {
            return new WXBizMsgCrtpy(env('WX3RD_TOKEN'), env('WX3RD_ENCODING_AES_KEY'), env('WX3RD_APP_ID'));
        });
    }
}