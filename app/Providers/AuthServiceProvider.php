<?php

namespace NEUQer\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use NEUQer\Extensions\AppTokenGuard;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'NEUQer\CETAdmission' => 'NEUQer\Policies\CETPolicy',
        'NEUQer\Wx3rdMP' => 'NEUQer\Policies\Wx3rdMPPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        \Auth::extend('app_token', function ($app, $name, array $config) {
            return new AppTokenGuard($app['request']);
        });
        $this->registerPolicies($gate);
        //
    }
}
