@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="{{ route('cabinet.profile.phone.verify') }}" method="post">
            @csrf
            @method('put')
            <div class="col-md-6 mt-3">
                <input type="text" name="sms-token" class="form-control" placeholder="Введите код из смс:">
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Подвердить</button>
            </div>
        </form>
    </div>
@endsection

