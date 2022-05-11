<?php

namespace App\Http\Controllers\Cabinet;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\SmsTokenRequest;
use App\Http\Services\Profile\PhoneService;
use App\Http\Services\Profile\ProfileService;
use Carbon\Carbon;
use App\Http\Services\Sms\SmsSender;
use Illuminate\Http\Request;

class PhoneController extends Controller
{
    private PhoneService $phoneService;
    private SmsSender $sms;

    public function __construct(PhoneService $phoneService, SmsSender $sms)
    {
        $this->phoneService = $phoneService;
        $this->sms = $sms;
    }

    public function request(Request $request)
    {
        $user = \Auth::user();

        try {
            $token = $user->requestPhoneVerification(Carbon::now());
            $this->sms->send($user->phone, 'Code ' . $token);
        } catch (\DomainException $exception) {
            $request->session()->flush('error', $exception->getMessage());
        }

        return redirect()->route('cabinet.profile.phone');
    }

    public function form()
    {
        $user = \Auth::user();

        return view('cabinet.profile.phone', compact('user'));
    }

    public function verify(SmsTokenRequest $request)
    {
        try {
            $this->phoneService->verifyPhone($request, \Auth::user(), Carbon::now());
        } catch (\DomainException $exception) {
            return redirect()->route('cabinet.profile.phone')->with('error', $exception->getMessage());
        }

        return redirect()->route('cabinet.profile.home');
    }
}
