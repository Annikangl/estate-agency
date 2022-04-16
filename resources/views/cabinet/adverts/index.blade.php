@extends('layouts.app')

@section('content')
    <div class="container">
        @include('cabinet.adverts._nav')

        <div class="row mb-2">
            <div class="d-flex justify-content-end">
                <a href="{{ route('cabinet.adverts.create') }}" class="btn btn-primary">Создать объявление</a>
            </div>
        </div>
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
                        @if ($advert->isDraft())
                            <span class="badge bg-secondary">Черновик</span>
                        @elseif ($advert->isModeration())
                            <span class="badge bg-primary">На модерации</span>
                        @elseif ($advert->isActive())
                            <span class="badge bg-primary">Активно</span>
                        @elseif ($advert->isClosed())
                            <span class="badge bg-secondary">Закрыто</span>
                        @endif
                    </td>
                </tr>
            @endforeach

            </tbody>
        </table>

        {{ $adverts->links() }}
    </div>
@endsection
