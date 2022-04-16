@extends('layouts.app')

@section('content')
    <div class="container">
        @include('cabinet.profile._nav')

        <div class="mb-3">
            <a href="{{ route('cabinet.profile.edit') }}" class="btn btn-primary">Редактировать</a>
        </div>

        <table class="table table-bordered">
            <tbody>
            <tr>
                <th>Имя</th>
                <td>{{ $user->name }}</td>
            </tr>
            <tr>
                <th>Фамилия</th>
                <td>{{ $user->last_name }}</td>
            </tr>
            <tr>
                <th>Электронная почта</th>
                <td>{{ $user->email }}</td>
            </tr>
            <tr>
                <th>Телефон</th>
                @if ($user->phone)
                    <td>{{ $user->phone }}
                        @if (!$user->isPhoneVerified())
                            <i>(Не подтвержден)</i><br>
                            <form action="{{ route('cabinet.profile.phone') }}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success">Подтвердить</button>
                            </form>
                        @endif
                    </td>
                @endif
            </tr>
            </tbody>
        </table>
    </div>
@endsection
