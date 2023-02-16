<?php

namespace Lanser\Elastic;
use Illuminate\Support\ServiceProvider;
use Lanser\Elastic\ElasticConnect\ElasticConnect;
use Lanser\Elastic\ElasticSearchBuilder\ElasticBuilder;
use Lanser\Elastic\ElasticSearchBuilder\Interfce\ElasticBuilderInterface;

class LanserElasticServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(ElasticConnect::class, function () {
            return (new ElasticConnect())->getElasticClient();
        });
        $this->app->bind(ElasticBuilderInterface::class, ElasticBuilder::class);
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {

            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('lanser-elastic.php'),
            ], 'config');

        }
    }
}