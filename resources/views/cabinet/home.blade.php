@extends('layouts.app')

@section('breadcrumbs', '')

@section('content')
    <div class="container">
    @include('cabinet._nav')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Панель управления') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('Вы авторизованы!') }}
                </div>
            </div>
        </div>
    </div>
    </div>

@endsection
