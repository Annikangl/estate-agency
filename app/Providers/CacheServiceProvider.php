<?php

namespace App\Providers;

use App\Models\Region;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class CacheServiceProvider extends ServiceProvider
{

    public function register()
    {
        //
    }


    public function boot()
    {
        $this->registerFlusher(Region::class);
    }

    private function registerFlusher($class): void
    {
        /** @var Model $class */
        $flush = function () use ($class) {
            \Cache::tags($class)->flush();
        };

        $class::created($flush);
        $class::saved($flush);
        $class::saved($flush);
        $class::deleted($flush);
    }
}
