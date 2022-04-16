<?php

namespace App\Http\Controllers\Cabinet\Advert;

use App\Http\Controllers\Controller;
use App\Http\Middleware\FilledProfile;
use App\Models\Adverts\Advert\Advert;
use Illuminate\Http\Request;

class AdvertController extends Controller
{
    public function __construct()
    {
        $this->middleware(FilledProfile::class);
    }

    public function index()
    {
        $adverts = Advert::ForUser(\Auth::user())->orderByDesc('id')->paginate(5);

        return view('cabinet.adverts.index', compact('adverts'));
    }
}
