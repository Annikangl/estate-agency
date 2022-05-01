@extends('layouts.app')

@section('content')
    <div class="container">
        @include('admin._nav')

        <div class="card mb-3">
            <div class="card-header">Фильтр</div>
            <div class="card-body">
                <form action="?" method="GET">
                    <div class="row">
                        <div class="col-sm-1">
                            <div class="form-group">
                                <label for="id" class="col-form-label">№ п/п</label>
                                <input id="id" class="form-control" name="id" value="{{ request('id') }}">
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div class="form-group">
                                <label for="user" class="col-form-label">Автор</label>
                                <input id="user" class="form-control" name="user" value="{{ request('user') }}">
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div class="form-group">
                                <label for="region" class="col-form-label">Регион</label>
                                <input id="region" class="form-control" name="region" value="{{ request('region') }}">
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div class="form-group">
                                <label for="category" class="col-form-label">Категория</label>
                                <input id="category" class="form-control" name="category"
                                       value="{{ request('category') }}">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="status" class="col-form-label">Статус</label>
                                <select id="status" class="form-control" name="status">
                                    <option value=""></option>
                                    @foreach ($statuses as $value => $label)
                                        <option
                                            value="{{ $value }}"{{ $value === request('status') ? ' selected' : '' }}>{{ $label }}</option>
                                    @endforeach;
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label class="col-form-label">&nbsp;</label><br/>
                                <button type="submit" class="btn btn-primary">Найти</button>
                                <a href="?" class="btn btn-outline-secondary">Сброс</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <table class="table table-striped">
            <thead>
            <tr>
                <th>№ п/п</th>
                <th>Название</th>
                <th>Автор</th>
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
                    <td><a href="{{ route('cabinet.banners.show', $banner) }}" target="_blank">{{ $banner->name }}</a>
                    </td>
                    <td>{{ $banner->user->id }} - {{ $banner->user->name }}</td>
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
    </div>
@endsection
