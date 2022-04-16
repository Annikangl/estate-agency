<?php

namespace App\Http\Controllers\Cabinet\Advert;

use App\Http\Controllers\Controller;
use App\Http\Middleware\FilledProfile;
use App\Http\Requests\Adverts\CreateAdvertRequest;
use App\Http\Services\Advert\AdvertService;
use App\Models\Adverts\Category;
use App\Models\Region;

class CreateController extends Controller
{
    private AdvertService $advertService;

    public function __construct(AdvertService $advertService)
    {
        $this->advertService = $advertService;
        $this->middleware(FilledProfile::class);
    }

    public function category()
    {
        $categories = Category::defaultOrder()->withDepth()->get()->toTree();

        return view('cabinet.adverts.create.category', compact('categories'));
    }

    public function region(Category $category, Region $region = null)
    {
        $regions = Region::where('parent_id', $region ? $region->id : null)->orderBy('name')->get();

        return view('cabinet.adverts.create.region', compact('category','region','regions'));
    }

    public function advert(Category $category, Region $region = null)
    {
        return view('cabinet.adverts.create.advert', compact('category','region'));
    }

    public function store(CreateAdvertRequest $request, Category $category, Region $region = null)
    {
        try {
            $advert = $this->advertService->create(
                \Auth::id(),
                $category->id,
                $region ? $region->id : null,
                $request
            );
        } catch (\DomainException $exception) {
            return back()->with('error', $exception->getMessage());
        }

        return redirect()->route('adverts.show', $advert);
    }

}
