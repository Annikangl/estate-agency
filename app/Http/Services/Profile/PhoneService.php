<?php


namespace App\Http\Services\Profile;


use App\Http\Requests\Profile\SmsTokenRequest;
use App\Models\User;
use Carbon\Carbon;

class PhoneService
{
    public function requestPhone()
    {

    }

    public function verifyPhone(SmsTokenRequest $request, User $user, $time): void
    {
        $user->verifyPhone($request['sms-token'], Carbon::now());
    }
}
