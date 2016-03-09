<?php
/**
 * Created by PhpStorm.
 * User: nicholas
 * Date: 16-3-9
 * Time: 下午9:58
 */

namespace NEUQer\Providers;


use Illuminate\Support\ServiceProvider;
use NEUQer\Console\Commands\InitAdminCommand;
use NEUQer\Console\Commands\InitCommand;

class InitCommandProvider extends ServiceProvider
{

    public function boot() {
        $this->commands([
            'command.init',
            'command.init.admin'
        ]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('command.init', function () {
            return new InitCommand();
        });
        $this->app->singleton('command.init.admin', function () {
            return new InitAdminCommand();
        });
    }
}