<?php


namespace App\Http\Services\Auth;


use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;

class RegisterService
{
    public function register(RegisterRequest $request): void
    {
        $user = User::register(
            $request['name'],
            $request['email'],
            $request['password']
        );

//        Mail::to($user->email)->send(new VerifyMail($user));
        event(new Registered($user));
    }

    public function verify(int $id)
    {
        $user = User::findOrFail($id);
        $user->verify();
    }
}
