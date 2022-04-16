<?php

namespace App\Http\Controllers\Admin\Advert;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Advert\EditRequest;
use App\Http\Requests\Adverts\Advert\AdvertAttributesRequest;
use App\Http\Requests\Adverts\RejectRequest;
use App\Http\Services\Advert\AdvertService;
use App\Models\Adverts\Advert\Advert;
use App\Models\User;
use Illuminate\Http\Request;

class AdvertController extends Controller
{
    private AdvertService $advertService;

    public function __construct(AdvertService $advertService)
    {
        $this->advertService = $advertService;
    }

    public function index(Request $request)
    {
        $query = Advert::orderByDesc('updated_at');

        if (!empty($value = $request->get('id'))) {
            $query->where('id', $value);
        }

        if (!empty($value = $request->get('title'))) {
            $query->where('title','like', '%'. $value . '%');
        }

        if (!empty($value = $request->get('user'))) {
            $query->where('user', $value);
        }

        if (!empty($value = $request->get('region'))) {
            $query->where('region', $value);
        }

        if (!empty($value = $request->get('category'))) {
            $query->where('category', $value);
        }

        if (!empty($value = $request->get('status'))) {
            $query->where('status', $value);
        }

        $adverts = $query->paginate(20);

        $statuses = Advert::statusesList();
        $roles = User::roleList();

        return view('admin.adverts.adverts.index', compact('adverts','statuses','roles'));
    }

    public function editForm(Advert $advert)
    {
        return view('adverts.edit.edit.advert', compact('advert'));
    }

    public function edit(EditRequest $request, Advert $advert)
    {
        try {
            $this->advertService->edit($advert->id, $request);
        } catch (\DomainException $exception) {
            return back()->with('error', $exception->getMessage());
        }

        return redirect()->route('adverts.show', $advert);
    }

    public function attributesForm(Advert $advert)
    {
        return view('adverts.edit.attributes', compact('advert'));
    }

    public function attributes(AdvertAttributesRequest $request, Advert $advert)
    {
        try {
            $this->advertService->editAttributes($advert->id, $request);
        } catch (\DomainException $exception) {
            return back()->with('error', $exception->getMessage());
        }

        return redirect()->route('Advert.show', $advert);
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

    public function rejectForm(Advert $advert)
    {
        return view('admin.adverts.adverts.reject', compact('advert'));
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

        return redirect()->route('admin.adverts.adverts.index');
    }

    private function getAdvert($id): Advert
    {
        return Advert::findOrFail($id);
    }
}
