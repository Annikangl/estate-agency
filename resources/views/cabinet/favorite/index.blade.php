@extends('layouts.app')

@section('content')
    <div class="container">
        @include('cabinet._nav')

        <table class="table table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>Updated</th>
                <th>Заголовок</th>
                <th>Регион</th>
                <th>Категория</th>
                <th>Статус</th>
            </tr>
            </thead>
            <tbody>

            @foreach ($adverts as $advert)
                <tr>
                    <td>{{ $advert->id }}</td>
                    <td>{{ $advert->updated_at }}</td>
                    <td><a href="{{ route('adverts.show', $advert) }}" target="_blank">{{ $advert->title }}</a></td>
                    <td>
                        @if ($advert->region)
                            {{ $advert->region->name }}
                        @endif
                    </td>
                    <td>{{ $advert->category->name }}</td>
                    <td>
                        <form action="{{ route('cabinet.favorites.remove', $advert) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Удалить</button>
                        </form>
                    </td>
                </tr>
            @endforeach

            </tbody>
        </table>

        {{ $adverts->links() }}
    </div>
@endsection
