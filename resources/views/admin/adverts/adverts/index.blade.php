@extends('layouts.app')

@section('content')
    <div class="container">
        @include('admin.adverts.adverts._nav')

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
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="name" class="col-form-label">Заголовок</label>
                                <input id="name" class="form-control" name="name" value="{{ request('name') }}">
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div class="form-group">
                                <label for="user" class="col-form-label">Пользователь</label>
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
                <th>Обновлено</th>
                <th>Заголовок</th>
                <th>Пользователь</th>
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
                    <td>{{ $advert->user->id }} - {{ $advert->user->name }}</td>
                    <td>
                        @if ($advert->region)
                            {{ $advert->region->id }} - {{ $advert->region->name }}
                        @endif
                    </td>
                    <td>{{ $advert->category->id }} - {{ $advert->category->name }}</td>
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
