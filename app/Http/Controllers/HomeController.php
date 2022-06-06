<?php

namespace App\Http\Controllers;


use App\Models\Adverts\Advert\Advert;
use App\Models\Adverts\Category;
use App\Models\Region;

class HomeController extends Controller
{
    public function index()
    {
        $regions = Region::roots()->orderBy('name')->getModels();

        $categories = Category::whereIsRoot()->defaultORder()->getModels();

        $recommendsAdverts = Advert::active()->limit(8)->get();

        $actualAdverts = Advert::active()->orderBy('published_at')->limit(6)->get();

        return view('welcome', compact(
            'regions','categories',
            'recommendsAdverts', 'actualAdverts'));
    }
}
