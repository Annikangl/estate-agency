<?php

namespace App\Http\Controllers;

use App\Http\Router\PagePath;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show(PagePath $path)
    {
        $page = $path->page;

        return view('page',compact('page'));
    }
}
