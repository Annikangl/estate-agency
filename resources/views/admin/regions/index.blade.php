@extends('layouts.app')

@section('content')
    <div class="container">
        @include('admin.regions._nav')
        <p><a href="{{ route('admin.regions.create') }}" class="btn btn-success mb-2">Добавить</a></p>

        @include('admin.regions._subregion_list', ['regions' => $regions])
    </div>
@endsection
