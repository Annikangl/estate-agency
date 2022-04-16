@extends('layouts.app')

@section('content')
    <div class="container">
        @include('cabinet.profile._nav')
        <form action="{{ route('cabinet.profile.update', $user) }}" method="post">
            @csrf
            @method('PUT')
            <div class="mb-3 col-md-4">
                <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                       name="name" id="name" value="{{ old('name',$user->name) }}">
                @if ($errors->has('name'))
                    <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                @endif
            </div>
            <div class="mb-3 col-md-4">
                <input type="text" class="form-control {{ $errors->has('last_name') ? 'is-invalid' : '' }}"
                       name="last_name" id="last_name" value="{{ old('last_name', $user->last_name) }}"
                       placeholder="Фамилия">
                @if ($errors->has('last_name'))
                    <div class="invalid-feedback">{{ $errors->first('last_name') }}</div>
                @endif
            </div>
            <div class="mb-3 col-md-4">
                <input type="tel" class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}"
                       name="phone" id="phone" value="{{ old('phone', $user->phone) }}" placeholder="Телефон">
                @if ($errors->has('phone'))
                    <div class="invalid-feedback">{{ $errors->first('phone') }}</div>
                @endif
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </div>
        </form>
    </div>
@endsection
