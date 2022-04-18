<?php

namespace App\Http\Controllers\Adverts;

use App\Http\Controllers\Controller;
use App\Models\Adverts\Advert\Advert;
use App\Models\Adverts\Category;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AdvertController extends Controller
{
    public function index(Region $region = null, Category $category = null)
    {
        $query = Advert::active()->with(['category','region'])->orderByDesc('published_at');

        if ($category) {
            $query->forCategory($category);
        }

        if ($region) {
            $query->forRegion($region);
        }

        $regions = $region
            ? $region->children()->orderBy('name')->getModels()
            : Region::roots()->orderBy('name')->getModels();

        $categories = $category
            ? $category->children()->defaultOrder()->getModels()
            : Category::whereIsRoot()->defaultOrder()->getModels();

        $adverts = $query->paginate(20);

        return view('adverts.index',
            compact('adverts','region','category','regions','categories'));
    }

    public function show(Advert $advert)
    {
        $user = \Auth::user();
//        if (!\Gate::allows('show-advert', $advert)) {
//            abort(403);
//        }

        return view('adverts.show', compact('advert','user'));
    }

    public function phone(Advert $advert): string
    {
        if (!$advert->isActive() || !$this->isAllowToShow($advert)) {
            abort(403);
        }

        return $advert->user->phone;
    }

    private function isAllowToShow(Advert $advert): bool
    {
        return \Gate::allows('show-advert', $advert);
    }
}
