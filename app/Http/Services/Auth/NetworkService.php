<?php


namespace App\Http\Services\Auth;


use App\Models\User;
use Illuminate\Support\Facades\DB;

class NetworkService
{
    public function auth(string $network, $data): User
    {
        if ($user = User::byNetwork($network, $data->getId())->first()) {
            return $user;
        }

        if ($data->getEmail() && $user = User::where('email', $data->getEmail())->exists()) {
            throw new \DomainException('Пользователь с таким email уже существует.');
        }

        $user = DB::transaction(function () use ($network, $data) {
            return User::registerByNetwork($network, $data->getId());
        });

        return $user;
    }
}
