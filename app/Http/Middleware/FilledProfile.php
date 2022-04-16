<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class FilledProfile
{

    public function handle(Request $request, Closure $next)
    {
        $user = \Auth::user();

        if (!$user->hasFilledProfile()) {
            return redirect()
                ->route('cabinet.profile.home')
                ->with('error', 'Пожалуйста, заполните ваш профиль и подтвердите номер телефона прежде чем создавать объявления');
        }

        return $next($request);
    }
}
