<?php

namespace App\Providers;

use App\Http\Services\Banner\CostCalculator;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class BannererviceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(CostCalculator::class, function (Application $app) {
            $config = $app->make('config')->get('banner');
            return new CostCalculator($config['price']);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
