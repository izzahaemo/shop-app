<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Shop App</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <script type="text/javascript" src="{{config('midtrans.snap_url')}}"
        data-client-key="{{config('midtrans.client_key')}}"></script>

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        .b-example-divider {
            width: 100%;
            height: 3rem;
            background-color: rgba(0, 0, 0, .1);
            border: solid rgba(0, 0, 0, .15);
            border-width: 1px 0;
            box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
        }
    </style>
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light  shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    Shop App
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        @if (Auth::check() && Auth::user()->hasRole('admin'))
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                                aria-expanded="false">Admin Menu</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('order') }}">{{ __('All Order') }}</a></li>
                                <li><a class="dropdown-item" href="{{ route('product_admin') }}">Product</a></li>
                                <li><a class="dropdown-item" href="{{ route('category_admin') }}">Category</a></li>
                            </ul>
                        </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('products') }}">{{ __('Products') }}</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                                aria-expanded="false">Categories</a>
                            <ul class="dropdown-menu">
                                @foreach ($categories as $category)
                                <li><a class="dropdown-item"
                                        href="{{ route('category',$category) }}">{{$category->name}}</a></li>
                                @endforeach
                            </ul>
                        </li>
                    </ul>

                    <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" action="{{ route('search') }}" method="POST"
                        role="search">
                        @csrf
                        <input name="search" type="search" class="form-control" placeholder="Search Product..."
                            aria-label="Search">
                    </form>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                        @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @endif

                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif
                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                @if (Auth::check() && Auth::user()->hasPermission('cart-read'))
                                <a class="dropdown-item" href="{{ route('cart') }}">{{ __('Your Charts') }}</a>
                                <a class="dropdown-item" href="{{ route('order') }}">{{ __('Your Order') }}</a>
                                @endif
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                        <li class="nav-item dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="bi bi-gear-fill theme-icon-active" data-theme-icon-active="bi-gear-fill"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><button class="dropdown-item d-flex align-itmes-center" type="button"
                                        data-bs-theme-value="light">
                                        <i class="bi bi-sun-fill me-2 opacity-50" data-theme-icon="bi-sun-fill"></i>
                                        Light
                                    </button>
                                </li>
                                <li><button class="dropdown-item d-flex align-itmes-center" type="button"
                                        data-bs-theme-value="dark">
                                        <i class="bi bi-moon-stars-fill me-2 opacity-50"
                                            data-theme-icon="bi-moon-stars-fill"></i>
                                        Dark
                                    </button>
                                </li>
                                <li><button class="dropdown-item d-flex align-itmes-center" type="button"
                                        data-bs-theme-value="auto">
                                        <i class="bi bi-circle-half me-2 opacity-50"
                                            data-theme-icon="bi-circle-half"></i>
                                        Auto
                                    </button>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>

        <div class="b-example-divider"></div>

        <div class="container">
            <footer class="py-3 my-4">
                <ul class="nav justify-content-center border-bottom pb-3 mb-3">
                    <li class="nav-item"><a href="{{ url('/') }}" class="nav-link px-2 text-body-secondary">Home</a>
                    </li>
                    <li class="nav-item"><a href="{{ route('products') }}"
                            class="nav-link px-2 text-body-secondary">Products</a></li>
                </ul>
                <p class="text-center text-body-secondary">&copy; 2023 Shop-App by Izzah, Inc</p>
            </footer>
        </div>
    </div>
</body>

</html>