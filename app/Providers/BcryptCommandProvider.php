<?php
/**
 * Created by PhpStorm.
 * User: nicholas
 * Date: 16-3-24
 * Time: 下午9:17
 */

namespace NEUQer\Providers;


use Illuminate\Support\ServiceProvider;
use NEUQer\Console\Commands\BcryptCommand;

class BcryptCommandProvider extends ServiceProvider
{
    public function boot() {
        $this->commands(['command.bcrypt']);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('command.bcrypt', function () {
            return new BcryptCommand();
        });
    }
}