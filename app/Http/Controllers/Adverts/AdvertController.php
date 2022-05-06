<?php

namespace App\Http\Controllers\Adverts;

use App\Http\Controllers\Controller;
use App\Http\Requests\Adverts\SearchRequest;
use App\Http\Services\Advert\SearchService;
use App\Models\Adverts\Advert\Advert;
use App\Models\Adverts\Category;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AdvertController extends Controller
{
    private SearchService $search;

    public function __construct(SearchService $searchService)
    {
        $this->search = $searchService;
    }

    public function index(SearchRequest $request, Region $region = null, Category $category = null)
    {
        $result = $this->search->search($category, $region, $request, 20, $request->get('page', 1));

        $adverts = $result->adverts;
        $regionCount = $result->regionsCount;
        $categoryCount = $result->categoryCount;

        $regions = $region
            ? $region->children()->orderBy('name')->getModels()
            : Region::roots()->orderBy('name')->getModels();

        $categories = $category
            ? $category->children()->defaultOrder()->getModels()
            : Category::whereIsRoot()->defaultOrder()->getModels();

        $regions = array_filter($regions, function (Region $region) use ($regionCount) {
            return isset($regionCount[$region->id]) && $regionCount[$region->id] > 0;
        });

        $categories = array_filter($categories, function (Category $category) use ($categoryCount) {
            return isset($categoryCount[$category->id]) && $categoryCount[$category->id] > 0;
        });


        return view('adverts.index',
            compact('category', 'region',
                'categories', 'regions',
                'regionCount', 'categoryCount',
                'adverts'));
    }

    public function show(Advert $advert)
    {
        $user = \Auth::user();
//        if (!\Gate::allows('show-advert', $advert)) {
//            abort(403);
//        }

        return view('adverts.show', compact('advert', 'user'));
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
