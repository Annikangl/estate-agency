<?php

namespace App\Http\Controllers\Cabinet\Banner;

use App\Http\Controllers\Controller;
use App\Http\Requests\Banners\CreateRequest;
use App\Http\Services\Banner\BannerService;
use App\Models\Adverts\Category;
use App\Models\Region;
use Illuminate\Http\Request;

class CreateController extends Controller
{
    private BannerService $bannerService;

    public function __construct(BannerService $bannerService)
    {
        $this->bannerService = $bannerService;
    }

    public function category()
    {
        $categories = Category::defaultOrder()->withDepth()->get()->toTree();

        return view('cabinet.banners.create.category', compact('categories'));
    }

    public function region(Category $category, Region $region = null)
    {
        $regions = Region::where('parent_id', $region ? $region->id : null)->orderBy('name')->get();

        return view('cabinet.banners.create.region', compact('category','region', 'regions'));
    }

    public function banner(Category $category, Region $region = null)
    {
        $formats = Banner::formatsList();

        return view('cabinet.banners.create.banner', compact('category', 'region', 'formats'));
    }

    public function store(CreateRequest $request, Category $category, Region $region = null)
    {
        try {
            $banner = $this->bannerService->create(
                \Auth::user(),
                $category,
                $region,
                $request
            );
        } catch (\DomainException $exception) {
            return back()->with('error', $exception->getMessage());
        }

        return redirect()->route('cabinet.banners.show', $banner);
    }
}
