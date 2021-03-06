<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>EstAG</title>

    <!-- Scripts -->

    <script src="{{ mix('js/app.js','assets') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <!-- Styles -->

    <link href="{{ mix('css/app.css', 'assets') }}" rel="stylesheet">

</head>
<body id="app">


<header>
    <nav class="navbar navbar-expand-md navbar-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Войти') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Регистрация') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('cabinet.home') }}">
                                    Личный кабинет
                                </a>
                                @can('admin-panel')
                                    <a class="dropdown-item" href="{{ route('admin.home') }}">
                                        Админка
                                    </a>
                                @endcan
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Выйти') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    @section('search')
        @include('layouts.partials.search', ['category' => null, 'action' => route('adverts.index') ])
    @show
</header>

<main class="app-content py-4 container">
        @section('breadcrumbs', Breadcrumbs::render() )
        @yield('breadcrumbs')
        @include('layouts.partials.flash')
        @yield('content')
</main>

<!-- Footer -->
<footer id="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-2 col-md-3 my-md-auto my-4">
                <h4 class="h3">E.State</h4>
            </div>
            <div class="col-lg-2 col-md-3 col-6 my-lg-auto my-4">
                <h6>Главное</h6>
                <hr color="#fff">
                <ul>
                    <li><a href="{{ route('home') }}">Главная</a></li>
                    <li><a href="{{ route('adverts.index') }}">Объяявления</a></li>
                    <li><a href="{{ route('cabinet.home') }}">Личный кабинет</a></li>
                </ul>
            </div>
            <div class="col-lg-2 col-md-3 col-6  my-lg-auto my-4">
                <h6>Категории</h6>
                <hr color="#fff">
                <ul>
                    <li><a href="#">Главная</a></li>
                    <li><a href="#">Объяявления</a></li>
                    <li><a href="#">Личный кабинет</a></li>
                </ul>
            </div>
            <div class="col-lg-2 col-md-3 col-6  my-lg-auto my-4">
                <h6>Регионы</h6>
                <hr color="#fff">
                <ul>
                    <li><a href="#">Главная</a></li>
                    <li><a href="#">Объяявления</a></li>
                    <li><a href="#">Личный кабинет</a></li>
                </ul>
            </div>
            <div class="col-lg-2">
                <h6>Котакты</h6>
                <hr color="#fff">
                <ul>
                    <li>071 333 71 33</li>
                    <li>estate@ex.com</li>
                </ul>
            </div>
        </div>
    </div>
</footer>
<!-- /Footer -->
@yield('scripts')
</body>
</html>
