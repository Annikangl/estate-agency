@extends('layouts.app')

@section('content')
    <div class="container">
        @include('admin.users._nav')
        <p><a href="{{ route('admin.users.create') }}" class="btn btn-success mb-2">Добавить</a></p>

        <div class="card mb-3">
            <div class="card-header">Фильтр</div>
            <div class="card-body">
                <form action="?" method="get">
                    <div class="row">
                        <div class="col-sm-1">
                            <div class="form-group">
                                <label for="id" class="col-form-label">№ п/п</label>
                                <input type="text" id="id" class="form-control" name="id" value="{{ request('id') }}">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="name" class="col-form-label">Имя пользователя</label>
                                <input type="text" id="name" class="form-control" name="name"
                                       value="{{ request('name') }}">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="email" class="col-form-label">Эл.почта</label>
                                <input type="text" id="email" class="form-control" name="email"
                                       value="{{ request('email') }}">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="status" class="col-form-label">Роль</label>
                                <select class="form-select" aria-label="status select" name="role">
                                    <option value=""></option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role }}" {{ $role === request('role') ? ' selected' : ''}}>
                                            {{ $role }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="role" class="col-form-label">Статус</label>
                                <select class="form-select" aria-label="Выберите роль" name="status">
                                    <option value=""></option>
                                    @foreach($statuses as $status)
                                        <option
                                            value="{{ $status }}" {{ $status === request('status') ? ' selected' : ''}}>
                                            {{ $status }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <div class="form-group">
                                    <label class="col-form-label">&nbsp;</label><br>
                                    <button type="submit" class="btn btn-primary">Найти</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th scope="col">№ п/п</th>
                <th scope="col">Имя пользователя</th>
                <th scope="col">Адрес эл.почты</th>
                <th scope="col">Статус</th>
                <th scope="col">Роль</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                @foreach($users as $user)
                    <th scope="row">{{ $user->id }}</th>
                    <td><a href="{{ route('admin.users.show', $user) }}">{{ $user->name }}</a></td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if ($user->isWait())
                            <span class="badge bg-secondary">Ожидает активации</span>
                        @elseif ($user->isActive())
                            <span class="badge bg-primary">Активен</span>
                        @endif
                    </td>
                    <td>
                        @if ($user->isAdmin())
                            <span class="badge bg-danger">Администратор</span>
                        @else
                            <span class="badge bg-secondary">Пользователь</span>
                        @endif
                    </td>
            </tr>
            @endforeach
            </tbody>
        </table>

        {{ $users->links() }}
    </div>
@endsection
