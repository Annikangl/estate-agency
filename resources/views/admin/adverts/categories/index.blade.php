@extends('layouts.app')

@section('content')
    <div class="container">
        @include('admin.adverts.categories._nav')
        <p><a href="{{ route('admin.advert.categories.create') }}" class="btn btn-success mb-2">Добавить</a></p>

        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th scope="col">Категория</th>
                <th scope="col">Slug</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($categories as $category)
                <tr>
                    <td>
                        @for($i = 0; $i < $category->depth; $i++) &mdash; @endfor
                        <a href="{{ route('admin.advert.categories.show', $category) }}">{{ $category->name }}</a>
                    </td>
                    <td>{{ $category->slug }}</td>
                    <td>
                        <div class="d-flex flex-row">
                            <form action="{{ route('admin.advert.categories.first', $category) }}" method="post">
                                @csrf
                                <button class="btn btn-sm btn-outline-primary">
                                    <span class="fa fa-angle-double-up"></span>
                                </button>
                            </form>
                            <form action="{{ route('admin.advert.categories.up', $category) }}" method="post">
                                @csrf
                                <button class="btn btn-sm btn-outline-primary">
                                    <span class="fa fa-angle-up"></span>
                                </button>
                            </form>
                            <form action="{{ route('admin.advert.categories.down', $category) }}" method="post">
                                @csrf
                                <button class="btn btn-sm btn-outline-primary">
                                    <span class="fa fa-angle-down"></span>
                                </button>
                            </form>
                            <form action="{{ route('admin.advert.categories.first', $category) }}" method="post">
                                @csrf
                                <button class="btn btn-sm btn-outline-primary">
                                    <span class="fa fa-angle-double-down"></span>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
