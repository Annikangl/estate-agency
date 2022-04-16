@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="{{ route('cabinet.adverts.create.advert.store', [$category,$region]) }}" method="post">
            @csrf

            <div class="card mb-3">
                <div class="card-header">
                    Описание
                </div>
                <div class="card-body pb-2">
                    <div class="row">
                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="title">Заголовок</label>
                                <input type="text" name="title"
                                       class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}"
                                       value="{{ old('title') }}" required>
                                @if ($errors->has('title'))
                                    <span class="invalid-feedback"><strong>{{ $errors->first('title') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="price">Цена</label>
                                <input type="number" id="price" name="price"
                                       class="form-control {{ $errors->has('price') ? ' is-invalid' : '' }}"
                                       value="{{ old('price') }}">
                                @if ($errors->has('price'))
                                    <span class="invalid-feedback"><strong>{{ $errors->first('price') }}</strong></span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="price">Адрес</label>
                        <input type="text" id="address" name="address"
                               class="form-control {{ $errors->has('address') ? ' is-invalid' : '' }}"
                               value="{{ old('address') }}" required>
                        @if ($errors->has('address'))
                            <span class="invalid-feedback"><strong>{{ $errors->first('address') }}</strong></span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="content">Описание</label>
                        <textarea name="content" id="content"
                                  class="form-control {{ $errors->has('content') ? ' is-invalid' : '' }}"
                                  rows="10" required>{{ old('content') }}</textarea>
                        @if ($errors->has('content'))
                            <span class="invalid-feedback"><strong>{{ $errors->first('content') }}</strong></span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header">
                    Характеристики
                </div>
                <div class="card-body pb-2">
                    @foreach($category->allAttributes() as $attribute)

                        <div class="form-group">
                            <label for="attribute_{{ $attribute->id}}"
                                   class="col-form-label">{{ $attribute->name }}</label>
                            @if ($attribute->isSelect())
                                <select name="attributes_[{{ $attribute->id }}]" id="attribute_{{ $attribute->id }}"
                                        class="form-control {{ $errors->has('attributes.' . $attribute->id) ? ' is-invalid' : '' }}">
                                    <option value=""></option>
                                    @foreach($attribute->typesList as $type)
                                        <option
                                            value="{{ $type }}" {{ $type === old('$attributes.' . $attribute->id) ? ' selected' : '' }}>
                                            {{ $type }}
                                        </option>
                                    @endforeach
                                </select>

                            @elseif($attributes->isNumber())
                                <input type="number" id="attribute_{{ $attribute->id }}"
                                       name="attributes_[{{ $attribute->id }}]"
                                       class="form-control {{ $errors->has('attributes.' . $attribute->id) ? ' is-invalid' : '' }}"
                                       value="{{ old('$attributes' . $attribute->id) }}">
                            @else
                                <input type="text" id="attribute_{{ $attribute->id }}"
                                       name="attributes_[{{ $attribute->id }}]"
                                       class="form-control {{ $errors->has('attributes.' . $attribute->id) ? ' is-invalid' : '' }}"
                                       value="{{ old('$attributes' . $attribute->id) }}">
                            @endif

                            @if($errors->has('parent'))
                                <span
                                    class="invalid-feedback"><strong>{{ $errors->first('attributes.' . $attribute->id) }}</strong></span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Создать объявление</button>
            </div>
        </form>
    </div>
@endsection
