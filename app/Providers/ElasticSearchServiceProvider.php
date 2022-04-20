<?php

namespace App\Providers;


use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class ElasticSearchServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->singleton(Client::class, function (Application $application){
            $config = $application->make('config')->get('elasticsearch');

            return ClientBuilder::create()
                ->setHosts($config['hosts'])
                ->setRetries($config['retries'])
                ->build();
        });
    }

    public function boot()
    {
        //
    }
}
