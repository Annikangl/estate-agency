@extends('layouts.app')

@section('search')
    @include('layouts.partials.search', ['category' => $category, 'action' => '?'])
@endsection
@section('content')
    <div class="container">

    <p><a href="{{ route('cabinet.adverts.create') }}" class="btn btn-success">Создать объявление</a></p>

    @if ($categories)
        <div class="card card-default mb-3">
            <div class="card-header">
                @if ($category)
                    Категория: {{ $category->name }}
                @else
                    Категории
                @endif
            </div>
            <div class="card-body pb0">
                <div class="row">
                    @foreach(array_chunk($categories,3) as $chunk)
                        <div class="col-md-3">
                            <ul class="list-unstyled">
                                @foreach($chunk as $current)
                                    <li>
                                        <a href="{{ route('adverts.index', [$current, $region]) }}">{{ $current->name }}</a>
                                        ({{ $categoryCount[$current->id] ?? 0 }})
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    @if ($regions)
        <div class="card card-default mb-3">
            <div class="card-header">
                @if ($region)
                    Регион: {{ $region->name }}
                @else
                    Регионы
                @endif
            </div>
            <div class="card-body pb0">
                <div class="row">
                    @foreach(array_chunk($regions,3) as $chunk)
                        <div class="col-md-3">
                            <ul class="list-unstyled">
                                @foreach($chunk as $current)
                                    <li>
                                        <a href="{{ route('adverts.index', [$current, $category]) }}">{{ $current->name }}</a>
                                        ({{ $regionCount[$current->id] ?? 0 }})
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

{{--        <section id="adverts-list-section" style="background-color: #eee;">--}}
{{--            <div class="container py-5">--}}
{{--                @foreach($adverts as $advert)--}}
{{--                    <div class="row justify-content-center mb-3">--}}
{{--                        <div class="col-md-12 col-xl-10">--}}
{{--                            <div class="card border rounded-3">--}}
{{--                                <div class="card-body">--}}
{{--                                    <div class="row">--}}
{{--                                        <div class="col-md-12 col-lg-3 col-xl-3 mb-4 mb-lg-0">--}}
{{--                                            <div class="bg-image hover-zoom ripple rounded ripple-surface">--}}
{{--                                                <img--}}
{{--                                                    src="https://21.img.avito.st/image/1/1.IKnoprayjEDeD05FpKYHmgMFjEZIB44.ENuS0dDwPI_WgU5dujaL4O5ENSqkl2HnHmiwHUiOVBI"--}}
{{--                                                    class="w-100"--}}
{{--                                                />--}}
{{--                                                <a href="#!">--}}
{{--                                                    <div class="hover-overlay">--}}
{{--                                                        <div--}}
{{--                                                            class="mask"--}}
{{--                                                            style="background-color: rgba(253, 253, 253, 0.15);"--}}
{{--                                                        ></div>--}}
{{--                                                    </div>--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-md-6 col-lg-6 col-xl-6">--}}
{{--                                            <h5>{{ $advert->title }}</h5>--}}
{{--                                            <div class="d-flex flex-row">--}}
{{--                                                <div class="text-danger mb-1 me-2">--}}
{{--                                                    <i class="fa fa-star"></i>--}}
{{--                                                    <i class="fa fa-star"></i>--}}
{{--                                                    <i class="fa fa-star"></i>--}}
{{--                                                    <i class="fa fa-star"></i>--}}
{{--                                                </div>--}}
{{--                                                <span>310</span>--}}
{{--                                            </div>--}}
{{--                                            <div class="mb-2 text-muted small">--}}
{{--                                                <span>{{ $advert->category->name }}</span>--}}
{{--                                            </div>--}}
{{--                                            <div class="mt-1 mb-0 text-muted small">--}}
{{--                                                <span>100% cotton</span>--}}
{{--                                                <span class="text-primary"> • </span>--}}
{{--                                                <span>Light weight</span>--}}
{{--                                                <span class="text-primary"> • </span>--}}
{{--                                                <span>Best finish<br /></span>--}}
{{--                                            </div>--}}
{{--                                            <div class="mt-1 mb-0 text-muted small">--}}
{{--                                                <span>Опубликовано: {{ $advert->created_at }}</span>--}}
{{--                                            </div>--}}

{{--                                        </div>--}}
{{--                                        <div class="col-md-6 col-lg-3 col-xl-3 border-sm-start-none border-start">--}}
{{--                                            <div class="d-flex flex-row align-items-center mb-1">--}}
{{--                                                <h4 class="mb-1 me-1">{{ $advert->price }} руб. за сутки</h4>--}}
{{--                                            </div>--}}
{{--                                            <h6 class="text-success">Актуальное</h6>--}}
{{--                                            <div class="d-flex flex-column mt-4">--}}
{{--                                                <a href="{{ route('adverts.show', $advert) }}" class="btn btn-primary btn-sm" type="button">Подробнее</a>--}}
{{--                                                <button class="btn btn-outline-primary btn-sm mt-2" type="button">--}}
{{--                                                    Добавить в Избранное--}}
{{--                                                </button>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                @endforeach--}}

{{--            </div>--}}
{{--        </section>--}}

        <div class="row">
            <div class="col-md-9">

                <div class="adverts-list">
                    @foreach ($adverts as $advert)
                        <div class="advert">
                            <div class="row">
                                <div class="col-md-3">
                                    <div style="height: 180px; background: #f6f6f6; border: 1px solid #ddd"></div>
                                </div>
                                <div class="col-md-9">
                                    <span class="float-right">{{ $advert->price }}</span>
                                    <div class="h4" style="margin-top: 0"><a href="{{ route('adverts.show', $advert) }}">{{ $advert->title }}</a></div>
                                    <p>Регион: <a href="">{{ $advert->region ? $advert->region->name : 'All' }}</a></p>
                                    <p>Категория: <a href="">{{ $advert->category->name }}</a></p>
                                    <p>Опубликовано: {{ $advert->created_at }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            {{ $adverts->links() }}
            </div>

        <div class="col">
            <div class="banner"
                 data-format="240x400"
                 data-url="{{ route('banner.get') }}"
                 data-category="{{ $category ? $category->id : '' }}"
                 data-region="{{ $region ? $region->id : '' }}">
            </div>
        </div>

    </div>

@endsection
