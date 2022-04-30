extends('layouts.app')

@section('content')
    @include('cabinet._nav')

    <div class="d-flex flex-row mb-3">

        @if ($banner->canBeChanged())
            <a href="{{ route('cabinet.banners.edit', $banner) }}" class="btn btn-primary mr-1">Редактировать</a>
            <a href="{{ route('cabinet.banners.file', $banner) }}" class="btn btn-primary mr-1">Изменить файл</a>
        @endif

        @if ($banner->isDraft())
            <form method="POST" action="{{ route('cabinet.banners.send', $banner) }}" class="mr-1">
                @csrf
                <button class="btn btn-success">Отправить на проверку</button>
            </form>
        @endif

        @if ($banner->isOnModeration())
            <form method="POST" action="{{ route('cabinet.banners.cancel', $banner) }}" class="mr-1">
                @csrf
                <button class="btn btn-secondary">Отменить проверку баннера</button>
            </form>
        @endif

        @if ($banner->isModerated())
            <form method="POST" action="{{ route('cabinet.banners.order', $banner) }}" class="mr-1">
                @csrf
                <button class="btn btn-success">Order for Payment</button>
            </form>
        @endif

        @if ($banner->canBeRemoved())
            <form method="POST" action="{{ route('cabinet.banners.destroy', $banner) }}" class="mr-1">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger">Удалить</button>
            </form>
        @endif
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
            <th>Url</th>
            <td><a href="{{ $banner->url }}">{{ $banner->url }}</a></td>
        </tr>
        <tr>
            <th>Лимит</th>
            <td>{{ $banner->limit }}</td>
        </tr>
        <tr>
            <th>Просмотров</th>
            <td>{{ $banner->views }}</td>
        </tr>
        <tr>
            <th>Дата публикации</th>
            <td>{{ $banner->published_at }}</td>
        </tr>
        </tbody>
    </table>

    <div class="card">
        <div class="card-body">
            <img src="{{ asset('storage/' . $banner->file) }}" />
        </div>
    </div>
@endsection
