@extends('layouts.app')

@section('content')
    <div class="container">
        @include('cabinet._nav')
        @if ($region)
            <p>
                <a href="{{ route('cabinet.adverts.create.advert', [$category, $region]) }}" class="btn btn-primary">
                    Создать объявление для региона {{ $region->name }}
                </a>
            </p>
        @else
            <p>
                <a href="{{ route('cabinet.adverts.create.advert', [$category]) }}" class="btn btn-primary">
                    Создать объявление для всей области
                </a>
            </p>
        @endif

        <p>Или выберите вложенный регион</p>
        <ul>
            @foreach($regions as $current)
                <li>
                    <a href="{{ route('cabinet.adverts.create.region', [$category, $current]) }}">{{ $current->name }}</a>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
