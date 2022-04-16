@extends('layouts.app')

@section('content')
    <div class="container">
    @if ($errors->all())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="?" method="post" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="photos" class="col-form-label">Title</label>
            <input type="file" name="files[]" id="photos"
                   class="form-control {{ $errors->has('photos') ? ' is-invalid' : '' }}" multiple required>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Загрузить</button>
        </div>
    </form>
    </div>
@endsection
