@extends('layouts.app')

@section('content')
    @include('cabinet._nav')
    <div class="container">
        <form action="{{ route('cabinet.banners.file', $banner) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="format" class="col-form-label">Формат баннера (размер)</label>
                <select id="format" class="form-control{{ $errors->has('format') ? ' is-invalid' : '' }}" name="format">
                    @foreach ($formats as $value)
                        <option
                            value="{{ $value }}"{{ $value === old('format') ? ' selected' : '' }}>{{ $value }}</option>
                    @endforeach;
                </select>
                @if ($errors->has('format'))
                    <span class="invalid-feedback"><strong>{{ $errors->first('format') }}</strong></span>
                @endif
            </div>

            <div class="form-group">
                <label for="file" class="col-form-label">Баннер</label>
                <input type="file" name="file" id="file" class="form-control{{ $errors->has('file') ? ' is-invalid' : '' }}">
            </div>

            <div class="form-group mt-3">
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </div>
        </form>
    </div>
@endsection
