<?php

namespace App\Http\Controllers\Cabinet;

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

    public function index()
    {
        $adverts = Advert::FavoredByUser(\Auth::user())->orderByDesc('id')->paginate(10);

        return view('cabinet.favorite.index', compact('adverts'));
    }

    public function remove(Advert $advert)
    {
        try {
            $this->favoriteService->remove(Auth::id(), $advert->id);
        } catch (\DomainException $exception) {
            return back()->with('error', $exception->getMessage());
        }

        return redirect()->route('cabinet.favorites.index');
    }
}
