<?php
/**
 * Created by PhpStorm.
 * User: nicholas
 * Date: 16-3-9
 * Time: 下午8:51
 */

namespace NEUQer\Providers;


use Illuminate\Support\ServiceProvider;
use NEUQer\Console\Commands\MigrateFromAppAuth;
use NEUQer\Console\Commands\MigrateFromAppBBS;
use NEUQer\Console\Commands\MigrateFromAppHome;
use NEUQer\Console\Commands\MigrateFromOld;

class MigrateFromOldProvider extends ServiceProvider
{

    public function boot() {
        $this->commands([
            'command.migrate.old',
            'command.migrate.app.auth',
            'command.migrate.app.home',
            'command.migrate.app.bbs'
        ]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('command.migrate.old', function () {
            return new MigrateFromOld();
        });
        $this->app->singleton('command.migrate.app.auth', function () {
            return new MigrateFromAppAuth();
        });
        $this->app->singleton('command.migrate.app.home', function () {
            return new MigrateFromAppHome();
        });
        $this->app->singleton('command.migrate.app.bbs', function () {
            return new MigrateFromAppBBS();
        });
    }
}