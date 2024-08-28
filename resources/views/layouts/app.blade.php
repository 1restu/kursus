<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <script src="https://unpkg.com/feather-icons"></script>

    <!-- Scripts -->
    @vite(['resources/sass/app.scss'])
    <style>
        /* Style yang sama seperti sebelumnya */
        #wrapper {
            display: flex;
            width: 100%;
            align-items: stretch;
            padding-top: 56px;
        }

        #sidebar-wrapper {
            min-height: 100vh;
            width: 250px;
            margin-left: -250px;
            transition: margin 0.25s ease-out;
            padding-top: 3px;
            z-index: 1030;
        }

        #wrapper.toggled #sidebar-wrapper {
            margin-left: 0;
        }

        #page-content-wrapper {
            width: 100%;
            padding: 20px;
            margin-top: 0;
        }

        .sb-sidenav-toggled #wrapper {
            margin-left: 250px;
        }

        @media (min-width: 768px) {
            #sidebar-wrapper {
                margin-left: 0;
            }

            #page-content-wrapper {
                padding: 20px;
            }
        }

        #sidebar-wrapper {
            position: fixed;
            left: -250px;
            width: 250px;
            height: 100%;
            background: #fff;
            transition: all 0.3s;
        }

        #wrapper.toggled #sidebar-wrapper {
            left: 0;
        }

        #page-content-wrapper {
            width: 100%;
            padding: 20px;
            transition: all 0.3s;
        }

        #wrapper.toggled #page-content-wrapper {
            margin-left: 250px;
        }

        main.py-4 {
            margin-top: 12px; /* Sesuaikan ini dengan tinggi navbar Anda */
        }

        #sidebarToggle {
            margin-right: 20px; /* Atur jarak sesuai kebutuhan */
        }

        .navbar-brand {
            margin-left: 20px; /* Atur jarak sesuai kebutuhan */
        }

        .list-group-item.active {
            background-color: #0d6efd;
            color: white;
            border-radius: 10px; /* Atur besar radius sesuai kebutuhan */
            border: none;
            padding-right: 20px; /* Memberikan jarak antara border kanan dengan link */
        }

        .list-group-item {
            padding: 10px 20px; /* Atur padding sesuai kebutuhan */
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            border: none;
        }
        .list-group-item:hover {
            background-color: rgba(0, 123, 255, 0.1); /* Efek hover yang halus */
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div id="wrapper">
        <!-- Sidebar-->
        <div class="border-end bg-white" id="sidebar-wrapper">
            {{-- <div class="sidebar-heading border-bottom bg-light">{{ config('app.name', 'Laravel') }}</div> --}}
            <div class="list-group list-group-flush">
                <a class="list-group-item list-group-item-action p-3 {{ Request::is('/') ? 'active' : '' }}" href="/">
                    <span data-feather="home" class="align-text-bottom mr-6"></span> Dashboard
                </a>
                <a class="list-group-item list-group-item-action p-3 {{ Request::is('categories') ? 'active' : '' }}" href="/categories">
                    <span data-feather="list"></span> Kategori
                </a>
                <a class="list-group-item list-group-item-action p-3 {{ Request::is('materies') ? 'active' : '' }}" href="/materies">
                    <span data-feather="book"></span> Materi
                </a>
                <a class="list-group-item list-group-item-action p-3 {{ Request::is('histories') ? 'active' : '' }}" href="/histories">
                    <span data-feather="clock"></span> Riwayat
                </a>
                <a class="list-group-item list-group-item-action p-3 {{ Request::is('courses') ? 'active' : '' }}" href="/courses">
                    <span data-feather="layers"></span> Daftar Kursus
                </a>
                <a class="list-group-item list-group-item-action p-3 {{ Request::is('students') ? 'active' : '' }}" href="/students">
                    <span data-feather="users"></span> Murid
                </a>
            </div>
        </div>
        <!-- Page content wrapper-->
        <div id="page-content-wrapper">
            <!-- Top navigation-->
            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm fixed-top">
                <div class="container">
                    @guest
                    @else 
                    <button class="btn btn-primary me-3" id="sidebarToggle"> ≡ </button>
                    @endguest
                    <a class="navbar-brand ml-5" href="{{ url('/') }}">
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
                        <ul class="navbar-nav ms-auto px-3">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
    <script>
        window.addEventListener('DOMContentLoaded', event => {
            const sidebarToggle = document.querySelector('#sidebarToggle');
            const wrapper = document.querySelector('#wrapper');
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', event => {
                    event.preventDefault();
                    wrapper.classList.toggle('toggled');
                });
            }

            // Inisialisasi Feather Icons
            feather.replace();
        });
    </script>
</body>
</html>
