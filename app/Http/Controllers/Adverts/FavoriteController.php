<?php

namespace App\Http\Controllers\Adverts;

use App\Http\Controllers\Controller;
use App\Http\Services\Advert\FavoriteService;
use App\Models\Adverts\Advert\Advert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    private FavoriteService $favoriteService;

    public function __construct(FavoriteService $favoriteService)
    {
        $this->favoriteService = $favoriteService;
        $this->middleware('auth');
    }

    public function add(Advert $advert)
    {
        try {
            $this->favoriteService->add(Auth::id(), $advert->id);
        } catch (\DomainException $exception) {
            return back()->with('error', $exception->getMessage());
        }

        return redirect()->route('adverts.show', $advert)->with('success','Объявление добавлено в Избранное');
    }

    public function remove(Advert $advert)
    {
        try {
            $this->favoriteService->remove(Auth::id(), $advert->id);
        } catch (\DomainException $exception) {
            return back()->with('error', $exception->getMessage());
        }

        return redirect()->route('adverts.show', $advert);

    }
}
