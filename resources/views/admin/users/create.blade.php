@extends('layouts.app')

@section('content')
    <div class="container">
        @include('admin.users._nav')

        <form action="{{ route('admin.users.store') }}" method="post" class="col-md-6">
            @csrf

            <div class="form-group">
                <label for="name" class="form-label">Имя пользователя</label>
                <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name"
                       value="{{ old('name') }}" required>
            </div>

            <div class="form-group">
                <label for="name" class="form-label">Адрес эл.почты</label>
                <input type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email"
                       value="{{ old('email') }}" required>
                @if ($errors->has('email'))
                    <div id="validationServerUsernameFeedback" class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                @endif
            </div>

            <div class="form-group mt-2">
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </div>
        </form>
    </div>
@endsection
