@extends('layouts.app')

@section('content')
    <div class="container">
    @if ($advert->isDraft())
        <div class="alert alert-danger">
            Это черновик
        </div>

        @if ($advert->reject_reason)
            <div class="alert alert-warning">
                {{ $advert->reject_reason }}
            </div>
        @endif
    @endif

    @can('moderate-advert', $advert)
        <div class="d-flex flex-row mb-3">
            <a href="{{ route('cabinet.adverts.edit', $advert) }}" class="btn btn-primary mx-1">Редактировать</a>
            <a href="{{ route('cabinet.adverts.photos', $advert) }}" class="btn btn-primary mx-1">Добавить фото</a>
            <form action="{{ route('cabinet.adverts.send', $advert) }}" method="post">
                @csrf
                @if ($advert->isDraft())
                    <button class="btn btn-success mx-1">Опубликовать</button>
                @endif
            </form>

            @if ($advert->isModeration() || $advert->isActive())
                <a href="{{ route('admin.advert.adverts.reject', $advert) }}" class="btn btn-danger mx-1">Отклонить</a>
            @endif

            <form action="{{ route('cabinet.adverts.destroy', $advert) }}" method="post">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger">Удалить</button>
            </form>
        </div>
    @endcan

    @can('manage-own-advert', $advert)
        <div class="d-flex flex-row mb-3">
            <a href="{{ route('cabinet.adverts.edit', $advert) }}" class="btn btn-primary mx-1">Редактировать</a>
            <a href="{{ route('cabinet.adverts.photos', $advert) }}" class="btn btn-primary mx-1">Добавить фото</a>
            <form action="{{ route('cabinet.adverts.send', $advert) }}" method="post">
                @csrf
                @if ($advert->isDraft())
                    <button class="btn btn-success">Опубликовать</button>
                @endif
            </form>

            @if ($advert->isModeration() || $advert->isActive())
                <a href="{{ route('admin.advert.adverts.reject', $advert) }}" class="btn btn-danger mx-1">Отклонить</a>
            @endif

            <form action="{{ route('cabinet.adverts.destroy', $advert) }}" method="post">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger">Удалить</button>
            </form>
        </div>
    @endcan

    <div class="row">
        <div class="col-md-9">

            <p class="float-end" style="font-size: 36px;">{{ $advert->price }} </p>
            <h1 style="margin-bottom: 10px;">{{ $advert->title }}</h1>
            <p>
                Дата размещения: {{ $advert->created_at }}
                @if ($advert->expired_at)
                    Истекает: {{ $advert->expired_at }}
                @endif
            </p>

            <div style="margin-bottom: 20px;">
                <div class="row">
                    <div class="col-10">
                        <div style="height: 400px; background: #f6f6f6; border: 1px solid #ddd"></div>
                    </div>
                    <div class="col-2">
                        <div style="height: 100px; background: #f6f6f6; border: 1px solid #ddd"></div>
                        <div style="height: 100px; background: #f6f6f6; border: 1px solid #ddd"></div>
                        <div style="height: 100px; background: #f6f6f6; border: 1px solid #ddd"></div>
                        <div style="height: 100px; background: #f6f6f6; border: 1px solid #ddd"></div>
                    </div>
                </div>
            </div>

            <p> {!! nl2br(e($advert->content)) !!}</p>
            <hr>

            <p>Адрес: {{ $advert->address }}</p>

            <div id="map" style="">
                <script src="//api-maps.yandex.ru/2.0-stable/?load=package.standard&lang=ru-RU"
                        type="text/javascript"></script>

                <script type='text/javascript'>
                    ymaps.ready(init);

                    function init() {
                        var geocoder = new ymaps.geocode(
                            '{{ $advert->address }}',
                            {results: 1}
                        );
                        geocoder.then(
                            function (res) {
                                var coord = res.geoObjects.get(0).geometry.getCoordinates();
                                var map = new ymaps.Map('map', {
                                    center: coord,
                                    zoom: 7,
                                    behaviors: ['default', 'scrollZoom'],
                                    controls: ['mapTools']
                                });
                                map.geoObjects.add(res.geoObjects.get(0));
                                map.zoomRange.get(coord).then(function (range) {
                                    map.setCenter(coord, range[1] - 1)
                                });
                                map.controls.add('mapTools')
                                    .add('zoomControl')
                                    .add('typeSelector');
                            }
                        );
                    }
                </script>
            </div>

            <p style="">Продавец: {{ $advert->user->name }}</p>

            <div class="d-flex">
                <span class="btn btn-success mx-1"><span class="fa fa-envelope"></span>Написать</span>
                <span class="btn btn-primary phone-button mx-1" data-source="{{ route('adverts.phone', $advert) }}">
                    <span class="fa fa-phone"></span>
                    <span class="number">Показать номер телефона</span></span>


            @if ($user && $user->hasInFavorite($advert->id))
                <form action="{{ route('adverts.favorites', $advert) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger"><span class="fa fa-star"></span>Удалить из Избранного</button>
                </form>
            @else
                <form action="{{ route('adverts.favorites', $advert) }}" method="post">
                    @csrf
                    <button class="btn btn-success"><span class="fa fa-star"></span>Добавить в Избранное</button>
                </form>
                @endif
            </div>

                <hr>

                <div class="h3">Похожие объявления</div>

                <div class="row">
                    <div class="col-sm-6 col-md-4">
                        <div class="card">
                            <img
                                src="https://images.pexels.com/photos/90946/pexels-photo-90946.jpeg?auto=compress&cs=tinysrgb&h=750&w=1260"
                                class="card-img-top" alt="">
                            <div class="card-body">
                                <div class="card-title h4 mt-0" style="">
                                    <a href="/catalog/show.html">THe first thing</a>
                                </div>
                                <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laborum,
                                    maiores?</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="card">
                            <img
                                src="https://images.pexels.com/photos/90946/pexels-photo-90946.jpeg?auto=compress&cs=tinysrgb&h=750&w=1260"
                                class="card-img-top" alt="">
                            <div class="card-body">
                                <div class="card-title h4 mt-0" style="">
                                    <a href="/catalog/show.html">THe first thing</a>
                                </div>
                                <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laborum,
                                    maiores?</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="card">
                            <img
                                src="https://images.pexels.com/photos/90946/pexels-photo-90946.jpeg?auto=compress&cs=tinysrgb&h=750&w=1260"
                                class="card-img-top" alt="">
                            <div class="card-body">
                                <div class="card-title h4 mt-0" style="">
                                    <a href="/catalog/show.html">THe first thing</a>
                                </div>
                                <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laborum,
                                    maiores?</p>
                            </div>
                        </div>
                    </div>
                </div>

        </div>
    </div>
    </div>
@endsection
