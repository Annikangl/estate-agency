@extends('layouts.app')

@section('content')
    <div class="container">
        @include('admin.regions._nav')

        <form action="{{ route('admin.advert.categories.store') }}" method="post">
            @csrf

            <div class="form-group">
                <label for="name" class="form-label">Имя категории</label>
                <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name"
                       value="{{ old('name', $category->name) }}" required>
            </div>

            <div class="form-group">
                <label for="slug" class="form-label">Slug</label>
                <input type="text" class="form-control {{ $errors->has('slug') ? 'is-invalid' : '' }}" name="slug"
                       value="{{ old('slug', $category->slug) }}" required>
            </div>

            <div class="form-group col-md-6 mb-3">
                <label for="parent-category__select">Родительская категория</label>
                <select class="form-select" id="parent-category__select" aria-label="parent-category-select">
                    <option value=""></option>
                    @foreach($parents as $parent)
                        <option value="{{ $parent->id }}" @if($parent->id === $category->parent) selected @endif>
                            @for($i = 0; $i < $parent->depth; $i++) &mdash; @endfor
                            {{ $parent->name }}
                        </option>
                    @endforeach
                </select>
                @if ($errors->has('parent'))
                    <span class="invalid-feedback"><strong>{{ $errors->first('parent') }}</strong></span>
                @endif
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </div>
        </form>
    </div>
@endsection
