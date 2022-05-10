<?php

namespace App\Http\Controllers\Auth\Networks;

use App\Http\Controllers\Controller;
use App\Http\Services\Auth\NetworkService;
use Laravel\Socialite\Facades\Socialite;

class FacebookController extends Controller
{
    private NetworkService $networkService;

    public function __construct(NetworkService $networkService)
    {
        $this->networkService = $networkService;
    }

    public function redirect()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function callback()
    {
        $data = Socialite::driver('facebook')->user();

        try {
            $user = $this->networkService->auth('facebook', $data);
            \Auth::login($user);
            return redirect()->intended();
        } catch (\DomainException $exception) {
            return redirect()->route('login')->with('error', $exception->getMessage());
        }
    }
}
