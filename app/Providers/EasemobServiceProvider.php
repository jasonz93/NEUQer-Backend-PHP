<?php
/**
 * Created by PhpStorm.
 * User: nicholas
 * Date: 16-3-14
 * Time: 下午8:14
 */

namespace NEUQer\Providers;


use Illuminate\Support\ServiceProvider;
use NEUQer\Console\Commands\EasemobBuildCommand;
use NEUQer\Console\Commands\EasemobClearCommand;
use NEUQer\SDK\Easemob\EasemobClient;

class EasemobServiceProvider extends ServiceProvider
{
    public function boot() {
        $this->commands([
            'command.easemob.clear',
            'command.easemob.build'
        ]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $config = $this->app['config']['easemob'];
        $client = new EasemobClient($config['orgName'], $config['appName'], $config['clientId'], $config['clientSecret']);

        $this->app->singleton('command.easemob.clear', function () use ($client) {
            return new EasemobClearCommand($client);
        });

        $this->app->singleton('command.easemob.build', function () use ($client) {
            return new EasemobBuildCommand($client);
        });
    }
}