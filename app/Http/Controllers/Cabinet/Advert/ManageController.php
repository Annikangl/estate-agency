<?php

namespace App\Http\Controllers\Cabinet\Advert;

use App\Http\Controllers\Controller;
use App\Http\Middleware\FilledProfile;
use App\Http\Requests\Adverts\Advert\AdvertAttributesRequest;
use App\Http\Requests\Adverts\PhotosRequest;
use App\Http\Requests\Adverts\RejectRequest;
use App\Http\Services\Advert\AdvertService;
use App\Models\Adverts\Advert\Advert;
use Illuminate\Http\Request;

class ManageController extends Controller
{
    private AdvertService $advertService;

    public function __construct(AdvertService $advertService)
    {
        $this->advertService = $advertService;
        $this->middleware(['auth', FilledProfile::class]);
    }

    public function editForm(Advert $advert)
    {
        $this->checkAccess($advert);
        return view('adverts.edit.edit', compact('advert'));
    }

    public function update(Request $request, Advert $advert)
    {
        $this->checkAccess($advert);
        try {
            $this->advertService->edit($request,$advert->id);
        } catch (\DomainException $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('adverts.show', $advert);

    }

    public function attributesForm(Advert $advert)
    {
        $this->checkAccess($advert);
        return view('adverts.edit.attributes', compact('advert'));
    }

    public function attributes(AdvertAttributesRequest $request, Advert $advert)
    {
        $this->checkAccess($advert);
        try {
            $this->advertService->editAttributes($advert->id, $request);
        } catch (\DomainException $exception) {
            return back()->with('error', $exception->getMessage());
        }

        return redirect()->route('Advert.show', $advert);
    }

    public function photosForm(Advert $advert)
    {
        $this->checkAccess($advert);
        return view('adverts.edit.photos', compact('advert'));
    }

    public function photos(PhotosRequest $request, Advert $advert)
    {
        $this->checkAccess($advert);
        try {
            $this->advertService->addPhotos($advert->id, $request);
        } catch (\DomainException $exception) {
            return back()->with('error', $exception->getMessage());
        }

        return redirect()->route('adverts.show', $advert);
    }

    public function moderate(Advert $advert)
    {
        try {
            $this->advertService->moderate($advert->id);
        } catch (\DomainException $exception) {
            return back()->with('error', $exception->getMessage());
        }

        return back();
    }

    public function reject($id, RejectRequest $request): void
    {
        $advert = $this->getAdvert($id);
        $advert->reject($request['reason']);
    }

    public function expire(Advert $advert): void
    {
        $advert->expire();
    }

    public function close(Advert $advert, RejectRequest $request)
    {
        try {
            $this->advertService->reject($advert->id, $request);
        } catch (\DomainException $exception) {
            return back()->with('error', $exception->getMessage());
        }

        return back();
    }

    public function destroy(Advert $advert)
    {
        try {
            $this->advertService->remove($advert->id);
        } catch (\DomainException $exception) {
            return back()->with('error', $exception->getMessage());
        }

        return redirect()->route('cabinet.adverts.index');
    }

    private function checkAccess(Advert $advert)
    {
        if (!\Gate::allows('manage-own-advert', $advert)) {
            abort(403);
        }
    }

    private function getAdvert($id): Advert
    {
        return Advert::findOrFail($id);
    }
}
