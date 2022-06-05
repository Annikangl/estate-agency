@extends('layouts.app')

@section('content')
    <div class="container">
        @include('admin._nav')

        <div class="d-flex flex-row mb-3">
            <a href="{{ route('admin.pages.edit', $page) }}" class="btn btn-primary mr-1">Редактировать</a>
            <form method="POST" action="{{ route('admin.pages.destroy', $page) }}" class="mr-1">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger">Удалить</button>
            </form>
        </div>

        <table class="table table-bordered table-striped">
            <tbody>
            <tr>
                <th>Идентификатор</th>
                <td>{{ $page->id }}</td>
            </tr>
            <tr>
                <th>Заголовок</th>
                <td>{{ $page->title }}</td>
            </tr>
            <tr>
                <th>Заголовокменю</th>
                <td>{{ $page->menu_title }}</td>
            </tr>
            <tr>
                <th>Slug</th>
                <td>{{ $page->slug }}</td>
            </tr>
            <tr>
                <th>Описание</th>
                <td>{{ $page->description }}</td>
            </tr>
            </tbody>
        </table>

        <div class="card">
            <div class="card-body pb-1">
                {!! nl2br($page->content) !!}
            </div>
        </div>

    </div>

@endsection
