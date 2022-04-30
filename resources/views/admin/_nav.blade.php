<ul class="nav nav-tabs mb-3">
    <li class="nav-item">
        <a href="{{ route('admin.home') }}" class="nav-link @if (Route::is('admin.home')) active @endif">
            Главная панель</a>
    </li>
    @can('manage-adverts')
        <li class="nav-item">
            <a href="{{ route('admin.advert.adverts.index') }}"
               class="nav-link @if (Route::is('admin.advert.adverts.*')) active @endif">Объявления</a>
        </li>
    @endcan
    @can('manage-users')
        <li class="nav-item">
            <a href="{{ route('admin.users.index') }}" class="nav-link @if (Route::is('admin.users.*')) active @endif">
                Пользователи
            </a>
        </li>
    @endcan
    @can('manage-categories')
        <li class="nav-item">
            <a href="{{ route('admin.advert.categories.index') }}"
               class="nav-link  @if (Route::is('admin.advert.categories.*')) active @endif">
                Категории
            </a>
        </li>
    @endcan
    @can('manage-regions')
        <li class="nav-item">
            <a href="{{ route('admin.regions.index') }}"
               class="nav-link  @if (Route::is('admin.regions.*')) active @endif">
                Регионы
            </a>
        </li>
    @endcan
    @can('manage-banners')
        <li class="nav-item">
            <a href="{{ route('admin.banners.index') }}"
               class="nav-link  @if (Route::is('admin.banners.*')) active @endif">
                Реклама
            </a>
        </li>
    @endcan
</ul>
