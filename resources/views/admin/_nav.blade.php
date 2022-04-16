<ul class="nav nav-tabs mb-3">
    <li class="nav-item">
        <a href="{{ route('admin.home') }}" class="nav-link @if (Route::is('admin.home')) active @endif">
            Главная панель</a>
    </li>
    @can('manage-adverts')
        <li class="nav-item">
            <a href="{{ route('admin.advert.adverts.index') }}"
               class="nav-link @if (Route::is('admin.advert.adverts.index')) active @endif">Объявления</a>
        </li>
    @endcan
    @can('manage-users')
        <li class="nav-item">
            <a href="{{ route('admin.users.index') }}" class="nav-link @if (Route::is('admin.users.index')) active @endif">
                Пользователи
            </a>
        </li>
    @endcan
    @can('manage-categories')
        <li class="nav-item">
            <a href="{{ route('admin.advert.categories.index') }}"
               class="nav-link  @if (Route::is('admin.advert.categories.index')) active @endif">
                Категории
            </a>
        </li>
    @endcan
    @can('manage-regions')
        <li class="nav-item">
            <a href="{{ route('admin.regions.index') }}"
               class="nav-link  @if (Route::is('admin.regions.index')) active @endif">
                Регионы
            </a>
        </li>
    @endcan
</ul>
