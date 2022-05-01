<?php

use App\Models\Banners\Banner;
use App\Models\Region;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// ------------------------------- Home -------------------------------
Breadcrumbs::for('home', function (BreadcrumbTrail $trailt) {
    $trailt->push('Главная', route('home'));
});

Breadcrumbs::for('login', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Вход', route('login'));
});

Breadcrumbs::for('register', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Регистрация', route('register'));
});

Breadcrumbs::for('password.request', function (BreadcrumbTrail $trail) {
    $trail->parent('login');
    $trail->push('Восстановление пароля', route('password.request'));
});

// ------------------------------- Cabinet -------------------------------
Breadcrumbs::for('cabinet.home', function (BreadcrumbTrail $trailt) {
    $trailt->push('Личный кабинет', route('cabinet.home'));
});
Breadcrumbs::for('cabinet.profile.home', function (BreadcrumbTrail $trailt) {
    $trailt->parent('cabinet.home');
    $trailt->push('Профиль', route('cabinet.profile.home'));
});
Breadcrumbs::for('cabinet.profile.edit', function (BreadcrumbTrail $trailt) {
    $trailt->parent('cabinet.profile.home');
    $trailt->push('Редактировать', route('cabinet.profile.edit'));
});

Breadcrumbs::for('cabinet.profile.phone', function (BreadcrumbTrail $trail) {
    $trail->parent('cabinet.profile.home');
    $trail->push('Подтверждение номера телефона', route('cabinet.profile.phone'));
});

// ------------------------------- Cabinet Advert -------------------------------
Breadcrumbs::for('cabinet.adverts.index', function (BreadcrumbTrail $trail) {
    $trail->parent('cabinet.home');
    $trail->push('Объявления', route('cabinet.adverts.index'));
});

Breadcrumbs::for('cabinet.adverts.create', function (BreadcrumbTrail $trail) {
    $trail->parent('adverts.index');
    $trail->push('Создать', route('cabinet.adverts.create'));
});

Breadcrumbs::for('cabinet.adverts.create.region', function (BreadcrumbTrail $trail, \App\Models\Adverts\Category $category, Region $region = null) {
    $trail->parent('cabinet.adverts.create');
    $trail->push($category->name, route('cabinet.adverts.create.region', [$category, $region]));
});

Breadcrumbs::for('cabinet.adverts.create.advert', function (BreadcrumbTrail $trail, \App\Models\Adverts\Category $category, Region $region = null) {
    $trail->parent('cabinet.adverts.create.region', $category, $region);
    $trail->push($region ? $region->name : 'Все', route('cabinet.adverts.create.advert', [$category,$region]));
});

Breadcrumbs::for('cabinet.adverts.photos', function (BreadcrumbTrail $trail, \App\Models\Adverts\Advert\Advert $advert) {
    $trail->parent('cabinet.adverts.create');
    $trail->push($advert->title, route('cabinet.adverts.photos', $advert));
});

// ------------------------------- Cabinet Favorites -------------------------------

Breadcrumbs::for('cabinet.favorites.index', function (BreadcrumbTrail $trail) {
    $trail->parent('cabinet.home');
    $trail->push('Избранное', route('cabinet.favorites.index'));
});

// ------------------------------- Cabinet Banners -------------------------------

Breadcrumbs::for('cabinet.banners.index', function (BreadcrumbTrail $crumbs) {
    $crumbs->parent('cabinet.home');
    $crumbs->push('Рекламные баннеры', route('cabinet.banners.index'));
});

Breadcrumbs::for('cabinet.banners.show', function (BreadcrumbTrail $crumbs, Banner $banner) {
    $crumbs->parent('cabinet.banners.index');
    $crumbs->push($banner->name, route('cabinet.banners.show', $banner));
});

Breadcrumbs::for('cabinet.banners.edit', function (BreadcrumbTrail $crumbs, Banner $banner) {
    $crumbs->parent('cabinet.banners.show', $banner);
    $crumbs->push('Изменить', route('cabinet.banners.edit', $banner));
});

Breadcrumbs::for('cabinet.banners.file', function (BreadcrumbTrail $crumbs, Banner $banner) {
    $crumbs->parent('cabinet.banners.show', $banner);
    $crumbs->push('Загрузить файл', route('cabinet.banners.file', $banner));
});

Breadcrumbs::for('cabinet.banners.create', function (BreadcrumbTrail $crumbs) {
    $crumbs->parent('cabinet.banners.index');
    $crumbs->push('Создать', route('cabinet.banners.create'));
});

Breadcrumbs::for('cabinet.banners.create.region', function (BreadcrumbTrail $crumbs, \App\Models\Adverts\Category $category, Region $region = null) {
    $crumbs->parent('cabinet.banners.create');
    $crumbs->push($category->name, route('cabinet.banners.create.region', [$category, $region]));
});

Breadcrumbs::for('cabinet.banners.create.banner', function (BreadcrumbTrail $crumbs, \App\Models\Adverts\Category $category, Region $region = null) {
    $crumbs->parent('cabinet.banners.create.region', $category, $region);
    $crumbs->push($region ? $region->name : 'All', route('cabinet.banners.create.banner', [$category, $region]));
});


// ------------------------------- Admin ----------------------

Breadcrumbs::for('admin.home', function (BreadcrumbTrail $trailt) {
    $trailt->push('Главная', route('admin.home'));
});

// Admin -> Users
Breadcrumbs::for('admin.users.index', function (BreadcrumbTrail $trailt) {
    $trailt->parent('admin.home');
    $trailt->push('Пользователи', route('admin.users.index'));
});
Breadcrumbs::for('admin.users.create', function (BreadcrumbTrail $trailt) {
    $trailt->parent('admin.users.index');
    $trailt->push('Создать', route('admin.users.create'));
});
Breadcrumbs::for('admin.users.show', function (BreadcrumbTrail $trailt, \App\Models\User $user) {
    $trailt->parent('admin.users.index');
    $trailt->push($user->name, route('admin.users.show', $user));
});
Breadcrumbs::for('admin.users.edit', function (BreadcrumbTrail $trailt, \App\Models\User $user) {
    $trailt->parent('admin.users.index');
    $trailt->push($user->name, route('admin.users.edit', $user));
});

// Admin -> Regions
Breadcrumbs::for('admin.regions.index', function (BreadcrumbTrail $trailt) {
    $trailt->parent('admin.home');
    $trailt->push('Регионы', route('admin.regions.index'));
});
Breadcrumbs::for('admin.regions.create', function (BreadcrumbTrail $trailt) {
    $trailt->parent('admin.regions.index');
    $trailt->push('Создать', route('admin.regions.create'));
});
Breadcrumbs::for('admin.regions.show', function (BreadcrumbTrail $trailt, Region $region) {
    if ($parent = $region->parent) {
        $trailt->parent('admin.regions.show', $parent);
    } else {
        $trailt->parent('admin.regions.index');
    }
    $trailt->push($region->name, route('admin.regions.show', $region));
});
Breadcrumbs::for('admin.regions.edit', function (BreadcrumbTrail $trailt, Region $region) {
    $trailt->parent('admin.regions.index');
    $trailt->push($region->name, route('admin.regions.edit', $region));
});


// Admin -> Categories
Breadcrumbs::for('admin.advert.categories.index', function (BreadcrumbTrail $trailt) {
    $trailt->parent('admin.home');
    $trailt->push('Категории', route('admin.advert.categories.index'));
});
Breadcrumbs::for('admin.advert.categories.create', function (BreadcrumbTrail $trailt) {
    $trailt->parent('admin.advert.categories.index');
    $trailt->push('Создать', route('admin.advert.categories.create'));
});
Breadcrumbs::for('admin.advert.categories.show', function (BreadcrumbTrail $trailt, \App\Models\Adverts\Category $category) {
    if ($parent = $category->parent) {
        $trailt->parent('admin.advert.categories.show', $parent);
    } else {
        $trailt->parent('admin.advert.categories.index');
    }
    $trailt->push($category->name, route('admin.advert.categories.show', $category));
});
Breadcrumbs::for('admin.advert.categories.edit', function (BreadcrumbTrail $trailt, \App\Models\Adverts\Category $category) {
    $trailt->parent('admin.advert.categories.index');
    $trailt->push($category->name, route('admin.advert.categories.edit', $category));
});


// Admin -> Categories -> Attribute
Breadcrumbs::for('admin.advert.categories.attributes.create', function (BreadcrumbTrail $trail,
                                                                        \App\Models\Adverts\Category $category) {
    $trail->parent('admin.advert.categories.show', $category);
    $trail->push('Создать', route('admin.advert.categories.attributes.create', $category));
});

Breadcrumbs::for('admin.advert.categories.attributes.show', function (BreadcrumbTrail $trail,
                                                                        \App\Models\Adverts\Category $category,
                                                                      \App\Models\Adverts\Attribute $attribute) {
    $trail->parent('admin.advert.categories.show', $category);
    $trail->push($attribute->name, route('admin.advert.categories.attributes.show', [$category, $attribute]));
});

Breadcrumbs::for('admin.advert.categories.attributes.edit', function (BreadcrumbTrail $trail,
                                                                        \App\Models\Adverts\Attribute $attribute,
                                                                        \App\Models\Adverts\Category $category) {
    $trail->parent('admin.advert.categories.show', $category);
    $trail->push('Создать', route('admin.advert.categories.attributes.edit', [$category, $attribute]));
});

// Admin -> Adverts -> Adverts
Breadcrumbs::for('admin.advert.adverts.index', function (BreadcrumbTrail $crumbs) {
    $crumbs->parent('admin.home');
    $crumbs->push('Объявление', route('admin.advert.adverts.index'));
});

Breadcrumbs::for('admin.advert.adverts.edit', function (BreadcrumbTrail $crumbs, \App\Models\Adverts\Advert\Advert $advert) {
    $crumbs->parent('admin.home');
    $crumbs->push($advert->title, route('admin.advert.adverts.edit', $advert));
});

Breadcrumbs::for('admin.advert.adverts.reject', function (BreadcrumbTrail $crumbs, \App\Models\Adverts\Advert\Advert $advert) {
    $crumbs->parent('admin.home');
    $crumbs->push($advert->title, route('admin.advert.adverts.reject', $advert));
});

// Admin -> Banners

Breadcrumbs::for('admin.banners.index', function (BreadcrumbTrail $crumbs) {
    $crumbs->parent('admin.home');
    $crumbs->push('Рекламные баннеры', route('admin.banners.index'));
});

Breadcrumbs::for('admin.banners.show', function (BreadcrumbTrail $crumbs, Banner $banner) {
    $crumbs->parent('admin.banners.index');
    $crumbs->push($banner->name, route('admin.banners.show', $banner));
});

Breadcrumbs::for('admin.banners.edit', function (BreadcrumbTrail $crumbs, Banner $banner) {
    $crumbs->parent('admin.banners.show', $banner);
    $crumbs->push('Изменить', route('admin.banners.edit', $banner));
});

Breadcrumbs::for('admin.banners.reject', function (BreadcrumbTrail $crumbs, Banner $banner) {
    $crumbs->parent('admin.banners.show', $banner);
    $crumbs->push('Отклонить', route('admin.banners.reject', $banner));
});

// ------------------------------- Adverts -------------------------------

Breadcrumbs::for('adverts.inner_region', function (BreadcrumbTrail $trail, Region $region = null, \App\Models\Adverts\Category $category = null) {
    if ($region && $parent = $region->parent) {
        $trail->parent('adverts.inner_region', $parent, $category);
    } else {
        $trail->parent('home', $region, $category);
        $trail->push('Объявления', route('adverts.index'));
    }
    if ($region) {
        $trail->push($region->name, route('adverts.index', $region, $category));
    }
});

Breadcrumbs::for('adverts.inner_category', function (BreadcrumbTrail $trail, Region $region = null, \App\Models\Adverts\Category $category = null) {
    if ($category && $parent = $category->parent) {
        $trail->parent('adverts.inner_category', $region, $parent);
    } else {
        $trail->parent('adverts.inner_region', $region, $category);
    }
    if ($category) {
        $trail->push($category->name, route('adverts.index', $region, $category));
    }
});

Breadcrumbs::for('adverts.index', function (BreadcrumbTrail $trail, Region $region = null, \App\Models\Adverts\Category $category = null) {
    $trail->parent('adverts.inner_category', $region, $category);
});

Breadcrumbs::for('adverts.index.all', function (BreadcrumbTrail $trail, Region $region = null, \App\Models\Adverts\Category $category = null) {
    $trail->parent('adverts.index', $region, $category);
});

Breadcrumbs::for('adverts.show', function (BreadcrumbTrail $trail, \App\Models\Adverts\Advert\Advert $advert) {
    $trail->parent('adverts.index', $advert->region, $advert->category);
    $trail->push($advert->title, route('adverts.show', $advert));
});
