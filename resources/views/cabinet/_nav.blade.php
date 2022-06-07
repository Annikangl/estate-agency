<ul class="nav nav-tabs mb-3">
    <li class="nav-item">
        <a href="{{ route('cabinet.home') }}" class="nav-link @if (Route::is('cabinet.home')) active @endif">Главная</a>
    </li>
    <li class="nav-item">
        <a href="{{ route('cabinet.adverts.index') }}" class="nav-link  @if (Route::is('cabinet.adverts.*')) active @endif">Мои объявления</a>
    </li>
    <li class="nav-item">
        <a href="{{ route('cabinet.profile.home') }}" class="nav-link  @if (Route::is('cabinet.profile.*')) active @endif">Профиль</a>
    </li>
    <li class="nav-item">
        <a href="{{ route('cabinet.favorites.index') }}" class="nav-link  @if (Route::is('cabinet.favorites.*')) active @endif">Избранное</a>
    </li>
    <li class="nav-item">
        <a href="{{ route('cabinet.banners.index') }}" class="nav-link  @if (Route::is('cabinet.banners.*')) active @endif">Реклама</a>
    </li>
    <li class="nav-item">
        <a href="{{ route('cabinet.tickets.index') }}" class="nav-link  @if (Route::is('cabinet.tickets.*')) active @endif">Тикеты</a>
    </li>
</ul>

