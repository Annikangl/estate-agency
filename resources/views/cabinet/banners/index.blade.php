@extends('layouts.app')

@section('content')
    <p><a href="{{ route('cabinet.banners.create') }}" class="btn btn-success">Add Banner</a></p>

    <table class="table table-striped">
        <thead>
        <tr>
            <th>№ п/п</th>
            <th>Название</th>
            <th>Регион</th>
            <th>Категория</th>
            <th>Опубликовано</th>
            <th>Статус</th>
        </tr>
        </thead>
        <tbody>

        @foreach ($banners as $banner)
            <tr>
                <td>{{ $banner->id }}</td>
                <td><a href="{{ route('cabinet.banners.show', $banner) }}" target="_blank">{{ $banner->name }}</a></td>
                <td>
                    @if ($banner->region)
                        {{ $banner->region->name }}
                    @endif
                </td>
                <td>{{ $banner->category->name }}</td>
                <td>{{ $banner->published_at }}</td>
                <td>
                    @if ($banner->isDraft())
                        <span class="badge bg-secondary">Черновик</span>
                    @elseif ($banner->isOnModeration())
                        <span class="badge bg-primary">На проверке</span>
                    @elseif ($banner->isModerated())
                        <span class="badge bg-success">Готово к оплате</span>
                    @elseif ($banner->isOrdered())
                        <span class="badge bg-warning">Ожидается оплата</span>
                    @elseif ($banner->isActive())
                        <span class="badge bg-primary">Активна</span>
                    @elseif ($banner->isClosed())
                        <span class="badge bg-secondary">Закрыта</span>
                    @endif
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>

    {{ $banners->links() }}
@endsection
