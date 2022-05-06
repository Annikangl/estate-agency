<?php

namespace App\Http\Controllers;

use App\Http\Services\Banner\BannerService;
use App\Models\Banners\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    private BannerService $bannerService;

    public function __construct(BannerService $bannerService)
    {
        $this->bannerService = $bannerService;
    }

    public function get(Request $request)
    {
        $format = $request['format'];
        $categoryId = $request['category'];
        $regionId = $request['region'];

        if (!$banner = $this->bannerService->getRandomForView($categoryId, $regionId, $format)) {
            return '';
        }

        return view('banner.get', compact('banner'));
    }

    public function click(Banner $banner)
    {
        $this->bannerService->click($banner->id);
        return redirect($banner->url);
    }
}
