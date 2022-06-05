@extends('layouts.app')

@section('content')
    <div class="container">
        @include('cabinet._nav')

        @if ($region)
            <p>
                <a href="{{ route('cabinet.banners.create.banner', [$category, $region]) }}" class="btn btn-success">
                    Разместить рекламу в {{ $region->name }}</a>
            </p>
        @else
            <p>
                <a href="{{ route('cabinet.banners.create.banner', $category) }}" class="btn btn-success">Разместить во всех регионах</a>
            </p>
        @endif

        <p>Или выберите регион:</p>

        <ul>
            @foreach ($regions as $current)
                <li>
                    <a href="{{ route('cabinet.banners.create.region', [$category, $current]) }}">{{ $current->name }}</a>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
