<?php

namespace Lanser\Elastic;
use Illuminate\Support\ServiceProvider;

class LanserElasticServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {

            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('lanser-elastic.php'),
            ], 'config');

        }
    }
}