<?php
/**
 * Created by PhpStorm.
 * User: trons
 * Date: 16-4-4
 * Time: 下午3:44
 */

namespace NEUQer\Providers;


use Endroid\QrCode\QrCode;
use Illuminate\Support\ServiceProvider;
use NEUQer\Services\QrcodeService;

class QrcodeProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->singleton('QrcodeGenerator', function(){
           return new QrcodeService();
        });
    }

}