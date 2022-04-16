@extends('layouts.app')

@section('content')
    <div class="container">
        @include('cabinet.adverts._nav')

        <p>Выберите категорию:</p>

        @include('cabinet.adverts.create._categories', ['categories' => $categories])
    </div>
@endsection
