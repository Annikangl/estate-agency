@extends('layouts.app')

@section('content')
    <div class="container">
        @include('admin.users._nav')

        <div class="d-flex flex-row mb-3">
            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary mr-1">Изменить</a>
            @if ($user->isWait())
                <form action="{{ route('admin.users.verify', $user) }}" method="post" class="mr-1">
                    @csrf
                    <button class="btn btn-primary">Активировать</button>
                </form>
            @endif
            <form action="{{ route('admin.users.destroy', $user) }}" method="post" class="mr-1">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger">Удалить</button>
            </form>
        </div>

        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th scope="col">№ п/п</th>
                <th scope="col">Адрес эл.почты</th>
                <th scope="col">Имя пользователя</th>
                <th scope="col">Статус</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <th scope="row">{{ $user->id }}</th>
                <td>{{ $user->email }}</td>
                <td><a href="{{ route('admin.users.show', $user) }}"></a>{{ $user->name }}</td>
                <td>
                    @if ($user->isWait())
                        <span class="badge bg-secondary">Ожидает активации</span>
                    @endif
                    @if ($user->isActive())
                        <span class="badge bg-primary">Активен</span>
                    @endif
                </td>
            </tr>
            </tbody>
        </table>
    </div>

@endsection
