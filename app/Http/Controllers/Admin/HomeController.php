<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Adverts\Advert\Advert;
use App\Models\Banners\Banner;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $adverts = Advert::orderByDesc('updated_at')->latest()->limit(3)->get();
        $banners = Banner::orderByDesc('created_at')->latest()->limit(3)->get();

        return view('admin.home', compact('adverts', 'banners'));
    }
}
