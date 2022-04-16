@component('mail::message')
# Подтверждение регистрации

Пожалуйста, перейдите по ссылке ниже, чтобы завершить регистрацию на сайте <b>EstAG - Агенство недвижимости</b>

@component('mail::button', ['url' => 'register.verify', ['token' => $user->verify_token]])
Подтвердить регистрацию
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
