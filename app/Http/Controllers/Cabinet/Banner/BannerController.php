<?php

namespace App\Http\Controllers\Cabinet\Banner;

use App\Http\Controllers\Controller;
use App\Http\Requests\Banners\EditRequest;
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

    public function index()
    {
        $banners = Banner::ForUser(\Auth::user())->orderByDesc('id')->paginate(6);

        return view('cabinet.banners.index', compact('banners'));
    }

    public function show(Banner $banner)
    {
        $this->checkAccess($banner);
        return view('cabinet.banners.show', compact('banner'));
    }

    public function editForm(Banner $banner)
    {
        $this->checkAccess($banner);
        if (!$banner->canBeChanged()) {
            return redirect()->route('cabinet.banners.show', $banner)->with('error', 'Не доступен для редактирования ');
        }

        return view('cabinet.banners.edit', compact('banner'));
    }

    public function edit(EditRequest $request, Banner $banner)
    {
        $this->checkAccess($banner);
        try {
            $this->bannerService->editByOwner($banner->id, $request);
        } catch (\DomainException $exception) {
            return back()->with('error', $exception->getMessage());
        }

        return redirect()->route('cabinet.banners.show', compact('banner'));
    }

    public function send(Banner $banner)
    {

    }

    public function order(Banner $banner)
    {
        $this->checkAccess($banner);

        try {
            $banner = $this->bannerService->order($banner->id);
        } catch (\DomainException $exception) {
            return back()->with('error', $exception->getMessage());
        }

        return redirect()->route('cabinet.banners.show', $banner);
    }

    public function destroy(Banner $banner)
    {
        try {
            $this->bannerService->removeByOwner($banner->id);
        } catch (\DomainException $exception) {
            return back()->with('error', $exception->getMessage());
        }

        return view('cabinet.banners.index', $banner);
    }

    private function checkAccess(Banner $banner): void
    {
        if (!\Gate::allows('manage-own-banner', $banner)) {
            abort(403);
        }
    }
}
