@extends('layouts.app')

@section('content')
    <div class="container">
        @include('admin.adverts.categories._nav')

        <form action="{{ route('admin.advert.categories.attributes.store', $category) }}"
              method="post" class="col-md-6">
            @csrf

            <div class="form-group">
                <label for="name" class="form-label">Атрибут</label>
                <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name"
                       value="{{ old('name') }}" required>
            </div>

            <div class="form-group">
                <label for="name" class="form-label">Sort</label>
                <input type="text" class="form-control {{ $errors->has('sort') ? 'is-invalid' : '' }}" name="sort"
                       value="{{ old('sort') }}" required>
                @if ($errors->has('sort'))
                    <div id="validationServerUsernameFeedback" class="invalid-feedback">
                        {{ $errors->first('sort') }}
                    </div>
                @endif
            </div>


            <div class="form-group col-md-6 mb-3">
                <label for="type">Тип атрибута</label>
                <select class="form-select" name="type" id="type" aria-label="parent-category-select">
                    @foreach($types as $type => $label)
                        <option value="{{ $type}}" @if($type === old('type')) selected @endif>
                            {{ $label}}
                        </option>
                    @endforeach
                </select>
                @if ($errors->has('type'))
                    <span class="invalid-feedback"><strong>{{ $errors->first('type') }}</strong></span>
                @endif
            </div>

            <div class="form-group">
                <label for="variants">Варианты</label>
                <textarea name="variants" id="variants"
                          class="form-control {{ $errors->has('sort') ? ' is-invalid' : '' }}"
                          cols="30" rows="10">{{ old('variants') }}
            </textarea>
                @if ($errors->has('variants'))
                    <span class="invalid-feedback"><strong>{{ $errors->first('variants') }}</strong></span>
                @endif
            </div>

            <div class="form-group">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="required"
                           id="required" {{ old('required') ? 'checked' : '' }}>

                    <label class="form-check-label" for="remember">
                        {{ __('Обязательный атрибут') }}
                    </label>
                </div>
                @if ($errors->has('required'))
                    <span class="invalid-feedback"><strong>{{ $errors->first('required') }}</strong></span>
                @endif
            </div>
            <div class="form-group mt-2">
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </div>
        </form>
    </div>
@endsection
