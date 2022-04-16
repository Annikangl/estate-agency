<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Services\Auth\RegisterService;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;


class RegisterController extends Controller
{
    protected string $redirectTo = '/cabinet/';
    private RegisterService $registerService;

    public function __construct(RegisterService $registerService)
    {
        $this->middleware('guest');
        $this->registerService = $registerService;
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request): RedirectResponse
    {
        $this->registerService->register($request);

        return redirect()->route('login')
            ->with('success', 'Проверьте вашу электронную почту и подтвердите регистрацию');
    }

    public function verify(string $token): RedirectResponse
    {
        if ($user = User::where('verify_token', $token)->first()) {
            return redirect()->route('login')
                ->with('error', 'Извините, ваша ссылка недействительна');
        }

        try {
            $this->registerService->verify($user->id);
            return redirect()->route('login')
                ->with('success', 'Ваш email успешно подтвержден! Теперь вы можете авторизоваться');
        } catch (\DomainException $exception) {
            return redirect()->route('login')
                ->with('error', $exception->getMessage());
        }
    }

    /*
     * Переопределяет стандартное поведение трейта,
     * убирает авторизацию пользователя сразу после регистрации
     */

    protected function registered(Request $request, $user)
    {
        $this->guard()->logout();

        return redirect()
            ->route('login')
            ->with('success', 'На вашу электронную почту отправлено письмо с ссылкой для подтверждения регистрации');
    }
}
