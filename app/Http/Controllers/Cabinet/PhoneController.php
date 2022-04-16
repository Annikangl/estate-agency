<?php

namespace App\Http\Controllers\Cabinet;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Http\Services\Sms\SmsSender;
use Illuminate\Http\Request;

class PhoneController extends Controller
{

    private $sms;

    public function __construct(SmsSender $sms)
    {
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

    public function verify(Request $request)
    {
        $request->validate([
            'sms-token' => 'required|string|max:15'
        ]);

        $user = \Auth::user();

        try {
            $user->verifyPhone($request['sms-token'], Carbon::now());
        } catch (\DomainException $exception) {
            return redirect()->route('cabinet.profile.phone')->with('error', $exception->getMessage());
        }

        return redirect()->route('cabinet.profile.home');
    }
}
