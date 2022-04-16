@extends('layouts.app')

@section('breadcrumbs', '')

@section('content')
    @include('includes.hero-section')

    @include('includes.about-section')

    @include('includes.services-section')

    @include('includes.property-section')

    @include('includes.work-section')

    @include('includes.last-adverts')

{{--    <div class="card card-default mb-3">--}}
{{--        <div class="card-header">--}}
{{--            Все категории--}}
{{--        </div>--}}
{{--        <div class="card-body pb-0" style="color: #aaa">--}}
{{--            <div class="row">--}}
{{--                @foreach (array_chunk($categories, 3) as $chunk)--}}
{{--                    <div class="col-md-3">--}}
{{--                        <ul class="list-unstyled">--}}
{{--                            @foreach ($chunk as $current)--}}
{{--                                <li><a href="{{ route('adverts.index.all', $current) }}">{{ $current->name }}</a></li>--}}
{{--                            @endforeach--}}
{{--                        </ul>--}}
{{--                    </div>--}}
{{--                @endforeach--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="card card-default mb-3">--}}
{{--        <div class="card-header">--}}
{{--            Все города--}}
{{--        </div>--}}
{{--        <div class="card-body pb-0" style="color: #aaa">--}}
{{--            <div class="row">--}}
{{--                @foreach (array_chunk($regions, 3) as $chunk)--}}
{{--                    <div class="col-md-3">--}}
{{--                        <ul class="list-unstyled">--}}
{{--                            @foreach ($chunk as $current)--}}
{{--                                <li><a href="{{ route('adverts.index', [$current, null]) }}">{{ $current->name }}</a></li>--}}
{{--                            @endforeach--}}
{{--                        </ul>--}}
{{--                    </div>--}}
{{--                @endforeach--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}


@endsection
