<?php

namespace App\Http\Controllers;


use App\Models\Adverts\Category;
use App\Models\Region;

class HomeController extends Controller
{
    public function index()
    {
        $regions = Region::roots()->orderBy('name')->getModels();

        $categories = Category::whereIsRoot()->defaultORder()->getModels();

        return view('welcome', compact('regions','categories'));
    }
}
