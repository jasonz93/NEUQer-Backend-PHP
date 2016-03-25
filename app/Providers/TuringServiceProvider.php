<?php
/**
 * Created by PhpStorm.
 * User: nicholas
 * Date: 16-3-23
 * Time: 下午8:22
 */

namespace NEUQer\Providers;


use Illuminate\Support\ServiceProvider;
use NEUQer\Services\TuringService;

class TuringServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $config = $this->app['config']['turing'];
        $this->app->singleton('Turing', function () use ($config) {
            return new TuringService($config['key']);
        });
    }
}