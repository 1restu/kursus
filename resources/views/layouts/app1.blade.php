<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Kursus Online')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://unpkg.com/feather-icons"></script>

    <!-- Scripts -->
    @vite(['resources/sass/app.scss'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
    <div id="wrapper" class="d-flex" style="padding-top: 56px; height: 100vh;">
        <!-- Sidebar-->
        @auth
        <div id="sidebar-wrapper" class="bg-dark text-white border-end" style="width: 250px; position: fixed; top: 0; bottom: 0; padding-top: 56px; box-shadow: 2px 0 10px rgba(0, 0, 0, 0.2);">
            <div class="list-group list-group-flush">
                <a class="list-group-item list-group-item-action {{ Request::is('/') ? 'active' : '' }}" href="/" style="background-color: #343a40; color: #ffffff;">
                    <i class="fas fa-home align-text-bottom me-2"></i>Dashboard
                </a>
                <a class="list-group-item list-group-item-action {{ Request::is('categories*') ? 'active' : '' }}" href="/categories" style="background-color: #343a40; color: #ffffff;">
                    <i class="fas fa-list me-2"></i>Kategori
                </a>
                <a class="list-group-item list-group-item-action {{ Request::is('materies*') ? 'active' : '' }}" href="/materies" style="background-color: #343a40; color: #ffffff;">
                    <i class="fas fa-book me-2"></i>Materi
                </a>
                <a class="list-group-item list-group-item-action {{ Request::is('histories*') ? 'active' : '' }}" href="/histories" style="background-color: #343a40; color: #ffffff;">
                    <i class="fas fa-clock me-2"></i>Riwayat
                </a>
                <a class="list-group-item list-group-item-action {{ Request::is('courses*') ? 'active' : '' }}" href="/courses" style="background-color: #343a40; color: #ffffff;">
                    <i class="fas fa-layer-group me-2"></i>Daftar Kursus
                </a>
                <a class="list-group-item list-group-item-action {{ Request::is('students*') ? 'active' : '' }}" href="/students" style="background-color: #343a40; color: #ffffff;">
                    <i class="fas fa-users me-2"></i>Murid
                </a>                
            </div>
        </div>
        
        @endauth
        <!-- Page content wrapper-->
        <div id="page-content-wrapper" class="flex-grow-1" style="margin-left: 250px; padding: 10px;">
            <!-- Top navigation-->
            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm fixed-top">
                <div class="container">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav me-auto">
                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ms-auto">
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
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
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

            <main class="py-4">
                @yield('content')
            </main>
        </div>
    </div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
    <script>
        window.addEventListener('DOMContentLoaded', event => {
            // Inisialisasi Feather Icons
            feather.replace();
        });
    </script>    
</body>
</html>
