@extends('layouts.app')

@section('content')
    <div class="container">
        @include('admin._nav')

        <div class="d-flex flex-row mb-3">

            <a href="{{ route('admin.banners.edit', $banner) }}" class="btn btn-primary mr-1">Изменить</a>

            @if ($banner->isOnModeration())
                <form method="POST" action="{{ route('admin.banners.moderate', $banner) }}" class="mr-1">
                    @csrf
                    <button class="btn btn-success">Отправить на оплату</button>
                </form>
                <a href="{{ route('admin.banners.reject', $banner) }}" class="btn btn-warning">Отклонить</a>
            @endif

            @if ($banner->isOrdered())
                <form method="POST" action="{{ route('admin.banners.pay', $banner) }}" class="mr-1">
                    @csrf
                    <button class="btn btn-success">Пометить как оплаченный</button>
                </form>
            @endif


            <form method="POST" action="{{ route('admin.banners.destroy', $banner) }}" class="mr-1">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger">Удалить</button>
            </form>
        </div>

        <table class="table table-bordered table-striped">
            <tbody>
            <tr>
                <th>№ п/п</th>
                <td>{{ $banner->id }}</td>
            </tr>
            <tr>
                <th>Название</th>
                <td>{{ $banner->name }}</td>
            </tr>
            <tr>
                <th>Регион</th>
                <td>
                    @if ($banner->region)
                        {{ $banner->region->name }}
                    @endif
                </td>
            </tr>
            <tr>
                <th>Категория</th>
                <td>{{ $banner->category->name }}</td>
            </tr>
            <tr>
                <th>Статус</th>
                <td>
                    @if ($banner->isDraft())
                        <span class="badge bg-secondary">Черновик</span>
                    @elseif ($banner->isOnModeration())
                        <span class="badge bg-primary">На проверке</span>
                    @elseif ($banner->isModerated())
                        <span class="badge bg-success">Готов к оплате</span>
                    @elseif ($banner->isOrdered())
                        <span class="badge bg-warning">Ожидает оплаты</span>
                    @elseif ($banner->isActive())
                        <span class="badge bg-primary">Активен</span>
                    @elseif ($banner->isClosed())
                        <span class="badge bg-secondary">Закрыта</span>
                    @endif
                </td>
            </tr>
            <tr>
                <th>Дата публикации</th>
                <td>{{ $banner->published_at }}</td>
            </tr>
            </tbody>
        </table>

        <div class="card">
            <div class="card-body">
                <img src="{{ asset('storage/' . $banner->file) }}"/>
            </div>
        </div>
    </div>
@endsection
