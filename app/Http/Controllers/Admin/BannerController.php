<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Requests\Banners\EditRequest;
use App\Http\Requests\Banners\RejectRequest;
use App\Http\Services\Banner\BannerService;
use App\Models\Banners\Banner;

class BannerController extends Controller
{
    private $bannerService;

    public function __construct(BannerService $bannerService)
    {
        $this->bannerService = $bannerService;
    }

    public function index(\Request $request)
    {
        $query = Banner::orderByDesc('updated_at');

        if (!empty($value = $request->get('id'))) {
            $query->where('id', $value);
        }

        if (!empty($value = $request->get('user'))) {
            $query->where('user_id', $value);
        }

        if (!empty($value = $request->get('region'))) {
            $query->where('region_id', $value);
        }

        if (!empty($value = $request->get('category'))) {
            $query->where('category_id', $value);
        }

        if (!empty($value = $request->get('status'))) {
            $query->where('status', $value);
        }

        $banners = $query->paginate(6);

        $statuses = Banner::statusesList();

        return view('admin.banners.index', compact('banners', 'statuses'));
    }

    public function show(Banner $banner)
    {
        return view('admin.banners.show', compact('banner'));
    }

    public function editForm(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

    public function edit(EditRequest $request, Banner $banner)
    {
        try {
            $this->bannerService->editByAdmin($banner->id, $request);
        } catch (\DomainException $exception) {
            return back()->with('error', $exception->getMessage());
        }

        return view('admin.banners.show', $banner);
    }

    public function moderate(Banner $banner)
    {
        try {
            $this->bannerService->moderate($banner->id);
        } catch (\DomainException $exception) {
            return back()->with('error', $exception->getMessage());
        }

        return view('admin.banners.show', $banner);
    }

    public function rejectForm(Banner $banner)
    {
        return view('admin.banners.reject', compact('banner'));
    }

    public function reject(RejectRequest $request, Banner $banner)
    {
        try {
            $this->bannerService->reject($banner->id, $request);
        } catch (\DomainException $exception) {
            return back()->with('error', $exception->getMessage());
        }

        return view('admin.banners.show', $banner);
    }

    public function markAsPayed(Banner $banner)
    {
        try {
            $this->bannerService->markAsPayed($banner->id);
        } catch (\DomainException $exception) {
            return back()->with('error', $exception->getMessage());
        }

        return view('admin.banners.show', $banner);
    }

    public function destroy(Banner $banner)
    {
        try {
            $this->bannerService->removeByAdmin($banner->id);
        } catch (\DomainException $exception) {
            return back()->with('error', $exception->getMessage());
        }

        return view('admin.banners.index', $banner);
    }
}
