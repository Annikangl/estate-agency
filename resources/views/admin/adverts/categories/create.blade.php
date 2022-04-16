@extends('layouts.app')

@section('content')
    <div class="container">
        @include('admin.regions._nav')

        <form method="POST" action="{{ route('admin.advert.categories.store') }}" class="col-md-6">
            @csrf

            <div class="form-group">
                <label for="name" class="form-label">Категория</label>
                <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name"
                       value="{{ old('name') }}" required>
            </div>

            <div class="form-group">
                <label for="name" class="form-label">Slug</label>
                <input type="text" class="form-control {{ $errors->has('slug') ? 'is-invalid' : '' }}" name="slug"
                       value="{{ old('slug') }}" required>
                @if ($errors->has('slug'))
                    <div id="validationServerUsernameFeedback" class="invalid-feedback">
                        {{ $errors->first('slug') }}
                    </div>
                @endif
            </div>

            <div class="form-group mt-2">
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </div>
        </form>
    </div>
@endsection
