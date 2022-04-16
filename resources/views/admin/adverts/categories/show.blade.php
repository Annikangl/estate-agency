@extends('layouts.app')

@section('content')
    <div class="container">
        @include('admin.adverts.categories._nav')

        <div class="d-flex flex-row mb-3">
            <a href="{{ route('admin.advert.categories.edit', $category) }}" class="btn btn-primary mr-1">Изменить</a>

            <form action="{{ route('admin.advert.categories.destroy', $category) }}" method="post" class="mr-1">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger">Удалить</button>
            </form>
        </div>

        <table class="table table-bordered table-striped">
            <tbody>
            <tr>
                <th>Категория</th>
                <td>{{ $category->name }}</td>
            </tr>
            <tr>
                <th>Slug</th>
                <td>{{ $category->slug }}</td>
            </tr>
            </tbody>
        </table>

        <a href="{{ route('admin.advert.categories.attributes.create', $category) }}"
           class="btn btn-primary mr-1">Добавить атрибут</a>

        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>Sort</th>
                <th>Атрибут</th>
                <th>SLug</th>
                <th>Обязательно *.</th>
            </tr>
            </thead>

            <tbody>
            @foreach($attributes as $attribute)
                <tr>
                    <td>{{ $attribute->sort }}</td>
                    <td>
                        <a href="{{ route('admin.advert.categories.attributes.show', [$category, $attribute]) }}">{{ $attribute->name }}</a>
                    </td>
                    <td>{{ $attribute->type }}</td>
                    <td>{{ $attribute->required  ? 'Yes': '' }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
