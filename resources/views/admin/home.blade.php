@extends('layouts.app')

@section('content')
    <div class="container">
        @include('admin._nav')

        <h3 class="h3-responsive">Последние действия</h3>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <p>Объявления</p>
                    </div>
                    <div class="card-body">
                        <ol class="list-group list-group-numbered">
                            @foreach($adverts as $advert)
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">
                                            <a href="{{ route('adverts.show', $advert) }}"
                                               target="_blank">{{ $advert->title }}</a>
                                        </div>
                                        Создатель: {{ $advert->user->name }}<br>
                                        Категория: {{ $advert->category->name }}<br>
                                        Создано: {{ $advert->created_at }} <br>
                                        @if ($advert->isDraft())
                                            <span class="badge bg-secondary">Черновик</span>
                                        @elseif ($advert->isModeration())
                                            <span class="badge bg-primary">На модерации</span>
                                        @elseif ($advert->isActive())
                                            <span class="badge bg-primary">Активно</span>
                                        @elseif ($advert->isClosed())
                                            <span class="badge bg-secondary">Закрыто</span>
                                        @endif
                                    </div>
                                    <span class="badge bg-primary rounded-pill">     {{ $advert->price }} руб</span>
                                </li>
                            @endforeach
                        </ol>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <p>Рекламные баннеры</p>
                    </div>
                    <div class="card-body">
                        <div class="row row-cols-1 row-cols-md-2 g-4">
                            @foreach($banners as $banner)
                                <div class="col">
                                    <div class="card">

                                        <img src="{{ asset('storage/' . $banner->file) }}" class="card-img-top" alt="banner">
                                        <div class="card-body">
                                            <h5 class="card-title">
                                                <a href="{{ route('admin.banners.show', $banner) }}"> {{ $banner->name }}</a>

                                            </h5>
                                            <p class="card-text">
                                                <span>Заказано показов: {{ $banner->limit }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
