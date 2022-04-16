@extends('layouts.app')

@section('content')
    <div class="container">
        @include('admin.adverts.categories._nav')

        <div class="d-flex flex-row mb-3">
            <a href="{{ route('admin.advert.categories.attributes.edit', [$category, $attribute]) }}"
               class="btn btn-primary">Изменить</a>

            <form action="{{ route('admin.advert.categories.attributes.destroy', [$category, $attribute]) }}"
                  method="post" class="mr-1">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger">Удалить</button>
            </form>
        </div>

        <table class="table table-bordered table-striped">
            <tbody>
            <tr>
                <th>Идентификатор</th>
                <td>{{ $attribute->id }}</td>
            </tr>
            <tr>
                <th>Категория</th>
                <td>{{ $category->name }}</td>
            </tr>
            <tr>
                <th>Атрибут</th>
                <td>{{ $attribute->name }}</td>
            </tr>

            <tr>
                <th>Тип</th>
                <td>{{ $attribute->type }}</td>
            </tr>
            </tbody>
        </table>
    </div>
@endsection
