@extends('layouts.app')

@section('content')
    <div class="container">
        @include('admin.regions._nav')

        <form action="{{ route('admin.users.store') }}" method="post">
            @csrf

            <div class="form-group">
                <label for="name" class="form-label">Имя пользователя</label>
                <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name"
                       value="{{ old('name', $user->name) }}" required>
            </div>

            <div class="form-group mb-3">
                <label for="name" class="form-label">Адрес эл.почты</label>
                <input type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email"
                       value="{{ old('email', $user->email) }}" required>
                @if ($errors->has('email'))
                    <div id="validationServerUsernameFeedback" class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                @endif
            </div>

            <div class="form-group col-md-6 mb-3">
                <select class="form-select" aria-label="Выберите роль">
                    @foreach($roles as $role)
                        <option value="{{ $role }}" @if($role === $user->role) selected @endif>{{ $role }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </div>
        </form>
    </div>
@endsection
