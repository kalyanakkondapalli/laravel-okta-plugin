<?php

namespace KalyanaKrishnaKondapalli\LaravelOkta;

use Illuminate\Support\ServiceProvider;

class OktaServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/okta.php', 'okta');
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/okta.php' => config_path('okta.php'),
        ], 'config');
    }
}
