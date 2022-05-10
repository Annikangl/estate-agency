<?php

use App\Http\Controllers\Admin\Advert\AttributesController;
use App\Http\Controllers\Admin\Advert\CategoryController;
use App\Http\Controllers\Admin\RegionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Adverts\AdvertController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Cabinet\Advert\CreateController;
use App\Http\Controllers\Cabinet\Advert\ManageController;
use App\Http\Controllers\Cabinet\FavoriteController;
use App\Http\Controllers\Cabinet\HomeController;
use App\Http\Controllers\Cabinet\PhoneController;
use App\Http\Controllers\Cabinet\ProfileController;
use Illuminate\Support\Facades\Route;


Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');


Auth::routes();

Route::get('login/facebook', [\App\Http\Controllers\Auth\Networks\FacebookController::class, 'redirect'])->name('auth.facebook');
Route::get('login/facebook/callback', [\App\Http\Controllers\Auth\Networks\FacebookController::class, 'callback']);
Route::get('login/vk', [\App\Http\Controllers\Auth\Networks\VkController::class, 'redirect'])->name('auth.vk');
Route::get('login/vk/callback', [\App\Http\Controllers\Auth\Networks\VkController::class, 'callback']);

Route::get('/banner/get', [\App\Http\Controllers\BannerController::class, 'get'])->name('banner.get');
Route::get('/banner/{banner}/click', [\App\Http\Controllers\BannerController::class, 'click'])->name('banner.click');

// frontend pages
Route::group(['prefix' => 'adverts', 'as'=>'adverts.'], function () {
   Route::get('/show/{advert}', [AdvertController::class, 'show'])->name('show');
   Route::post('/show/{advert}/phone', [AdvertController::class,'phone'])->name('phone');

   Route::get('/all/{category?}', [AdvertController::class,'index'])->name('index.all');
   Route::get('/{region?}/{category?}', [AdvertController::class,'index'])->name('index');

   Route::post('/favorites/{advert}', [\App\Http\Controllers\Adverts\FavoriteController::class, 'add'])->name('favorites');
   Route::delete('/favorites/{advert}', [\App\Http\Controllers\Adverts\FavoriteController::class, 'remove'])->name('favorites');
});

// Cabinet
Route::group(['middleware' => 'auth', 'prefix' => 'cabinet', 'as' => 'cabinet.'], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {
        Route::get('/', [ProfileController::class, 'index'])->name('home');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::put('/update', [ProfileController::class, 'update'])->name('update');
        Route::post('/phone', [PhoneController::class,'request']);
        Route::get('/phone', [PhoneController::class,'form'])->name('phone');
        Route::put('/phone', [PhoneController::class,'verify'])->name('phone.verify');
    });

    Route::get('favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::delete('favorites/{advert}', [FavoriteController::class, 'remove'])->name('favorites.remove');

    Route::group(['prefix' => 'adverts', 'as' => 'adverts.','middleware' => \App\Http\Middleware\FilledProfile::class], function () {
        Route::get('/',[\App\Http\Controllers\Cabinet\Advert\AdvertController::class,'index'])->name('index');
        Route::get('/create', [CreateController::class,'category'])->name('create');
        Route::get('/create/region/{category}/{region?}', [CreateController::class,'region'])->name('create.region');
        Route::get('/create/advert/{category}/{region?}', [CreateController::class,'advert'])->name('create.advert');
        Route::post('/create/advert/{category}/{region?}', [CreateController::class,'store'])->name('create.advert.store');

        Route::get('/{advert}/edit', [ManageController::class, 'editForm'])->name('edit');
        Route::put('/{advert}/edit', [ManageController::class, 'update']);
        Route::get('/{advert}/photos', [ManageController::class, 'photosForm'])->name('photos');
        Route::post('/{advert}/photos', [ManageController::class, 'photos']);
        Route::get('/{advert}/attributes', [ManageController::class, 'attributesForm'])->name('attributes');
        Route::post('/{advert}/attributes', [ManageController::class, 'attributes']);
        Route::post('/{advert}/send', [ManageController::class, 'moderate'])->name('send');
        Route::post('/{advert}/reject', [ManageController::class, 'reject'])->name('reject');
        Route::post('/{advert}/close', [ManageController::class,'close'])->name('close');
        Route::delete('/{advert}/destroy', [ManageController::class, 'destroy'])->name('destroy');
    });


    Route::group(['prefix' => 'banners', 'as' => 'banners.', 'middleware' => \App\Http\Middleware\FilledProfile::class], function () {
        Route::get('/', [\App\Http\Controllers\Cabinet\Banner\BannerController::class, 'index'])
            ->name('index');
        Route::get('/create', [\App\Http\Controllers\Cabinet\Banner\CreateController::class,'category'])
            ->name('create');
        Route::get('/create/region/{category}/{region?}', [\App\Http\Controllers\Cabinet\Banner\CreateController::class, 'region'])
            ->name('create.region');
        Route::get('/create/banner/{category}/{region?}', [\App\Http\Controllers\Cabinet\Banner\CreateController::class, 'banner'])
            ->name('create.banner');
        Route::post('/create/banner/{category}/{region?}', [\App\Http\Controllers\Cabinet\Banner\CreateController::class, 'store'])
            ->name('create.banner.store');

        Route::get('/show/{banner}', [\App\Http\Controllers\Cabinet\Banner\BannerController::class, 'show'])
            ->name('show');
        Route::get('/{banner}/edit', [\App\Http\Controllers\Cabinet\Banner\BannerController::class, 'editForm'])
            ->name('edit');
        Route::get('/{banner}/edit/file', [\App\Http\Controllers\Cabinet\Banner\BannerController::class, 'fileForm'])
            ->name('file');
        Route::put('/{banner}/edit/file', [\App\Http\Controllers\Cabinet\Banner\BannerController::class, 'file']);
        Route::put('/{banner}/edit', [\App\Http\Controllers\Cabinet\Banner\BannerController::class, 'edit']);
        Route::post('/{banner}/send', [\App\Http\Controllers\Cabinet\Banner\BannerController::class, 'send'])
            ->name('send');
        Route::post('/{banner}/cancel', [\App\Http\Controllers\Cabinet\Banner\BannerController::class, 'cancel'])
            ->name('cancel');
        Route::post('/{banner}/order', [\App\Http\Controllers\Cabinet\Banner\BannerController::class, 'order'])
            ->name('order');
        Route::delete('/{banner}/destroy', [\App\Http\Controllers\Cabinet\Banner\BannerController::class, 'destroy'])
            ->name('destroy');
    });

});


// Verify email
Route::get('/verify/{token}', [RegisterController::class, 'verify'])
    ->name('register.verify');

// Admin
Route::group(
    [
        'middleware' => ['auth','can:admin-panel'],
        'prefix' => 'admin',
        'as' => 'admin.'
    ],
    function () {
    Route::get('/', [\App\Http\Controllers\Admin\HomeController::class, 'index'])->name('home');
    Route::resource('users', UserController::class);
    Route::post('users/{user}/verify', [UserController::class, 'verify'])->name('users.verify');

    Route::resource('regions', RegionController::class);

    Route::group(['prefix' => 'advert', 'as' => 'advert.'], function () {
        Route::resource('categories', CategoryController::class);

        Route::group(['prefix' => 'categories/{category}', 'as' => 'categories.'], function () {
            Route::post('/first', [CategoryController::class, 'first'])->name('first');
            Route::post('/up', [CategoryController::class, 'up'])->name('up');
            Route::post('/down', [CategoryController::class, 'down'])->name('down');
            Route::post('/last', [CategoryController::class, 'last'])->name('last');
            Route::resource('attributes', AttributesController::class)->except('index');
        });

        Route::group(['prefix' => 'adverts', 'as' => 'adverts.', 'namespace' => ''], function () {
            Route::get('/', [\App\Http\Controllers\Admin\Advert\AdvertController::class, 'index'])->name('index');
            Route::get('/{advert}/edit', [\App\Http\Controllers\Admin\Advert\AdvertController::class, 'editForm'])
                ->name('edit');
            Route::put('/{advert}/edit', [\App\Http\Controllers\Admin\Advert\AdvertController::class, 'edit']);
            Route::get('/{advert}/attributes', [\App\Http\Controllers\Admin\Advert\AdvertController::class,'attributesForm'])
                ->name('attributes');
            Route::post('/{advert}/attributes', [\App\Http\Controllers\Admin\Advert\AdvertController::class, 'attributes']);
            Route::post('/{advert}/moderate', [\App\Http\Controllers\Admin\Advert\AdvertController::class, 'moderate'])
                ->name('moderate');
            Route::get('/{advert}/reject', [\App\Http\Controllers\Admin\Advert\AdvertController::class,'rejectForm'])
                ->name('reject');
            Route::post('/{advert}/reject', [\App\Http\Controllers\Admin\Advert\AdvertController::class,'reject']);
            Route::delete('/{advert}/destroy', [\App\Http\Controllers\Admin\Advert\AdvertController::class, 'destroy'])
                ->name('destroy');
        });
    });

        Route::group(['prefix' => 'banners', 'as' => 'banners.'], function () {
            Route::get('/', [\App\Http\Controllers\Admin\BannerController::class, 'index'])->name('index');
            Route::get('/{banner}/show', [\App\Http\Controllers\Admin\BannerController::class, 'show'])->name('show');
            Route::get('/{banner}/edit', [\App\Http\Controllers\Admin\BannerController::class, 'editForm'])->name('edit');
            Route::put('/{banner}/edit', [\App\Http\Controllers\Admin\BannerController::class, 'edit']);
            Route::post('/{banner}/moderate', [\App\Http\Controllers\Admin\BannerController::class, 'moderate'])->name('moderate');
            Route::get('/{banner}/reject', [\App\Http\Controllers\Admin\BannerController::class, 'rejectForm'])->name('reject');
            Route::post('/{banner}/reject', [\App\Http\Controllers\Admin\BannerController::class, 'reject']);
            Route::post('/{banner}/pay', [\App\Http\Controllers\Admin\BannerController::class, 'markAsPayed'])->name('pay');
            Route::delete('/{banner}/destroy', [\App\Http\Controllers\Admin\BannerController::class, 'destroy'])->name('destroy');
        });

    });

