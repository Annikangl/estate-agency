<?php

use App\Models\Region;
use App\Models\Adverts\Category;

if (! function_exists('adverts_path')) {
   function adverts_path(?Region $region, ?Category $category): \App\Http\Router\AdvertPath
   {
       return app()->make(\App\Http\Router\AdvertPath::class)
           ->withRegion($region)
           ->withCategory($category);
   }
}
