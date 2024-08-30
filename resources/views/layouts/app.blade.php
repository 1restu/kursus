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
    <style>
        /* Style yang sama seperti sebelumnya */
        /* Gaya untuk wrapper sidebar */
/* Gaya untuk wrapper sidebar */
#wrapper {
    display: flex;
    width: 100%;
    align-items: stretch;
    padding-top: 56px;
    height: 100vh; 
}

#sidebar-wrapper {
    width: 250px;
    background-color: #f8f9fa;
    padding-top: 10px;
    z-index: 1030;
    position: fixed;
    left: 0;
    border: none;
    box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
    height: 100vh;
}

#page-content-wrapper {
    width: calc(100% - 250px);
    padding: 10px;
    margin-left: 250px;
    flex: 1;
}

@media (min-width: 768px) {
    #page-content-wrapper {
        padding: 20px;
    }
}

/* Atur margin dan gaya tambahan sesuai kebutuhan Anda */
/* main.py-4 {
    margin-top: 2px;
} */

/* .navbar-brand {
    margin-left: 20px;
} */

.list-group-item.active {
    background-color: #0d6efd;
    color: white;
    border-radius: 8px;
    border: none;
    padding-right: 15px;
}

.list-group-item {
    display: flex;
    align-items: center;
    padding: 8px 15px;
    margin-bottom: 5px;
    border: none;
    transition: background-color 0.3s ease;
}
.list-group-item span[data-feather] {
    margin-right: 10px; 
    display: inline-block; 
    vertical-align: middle; 
}

/* .list-group-item:hover {
    background-color: rgba(13, 110, 253, 0.1);
    border-radius: 8px;
} */

    </style>
</head>
<body>
    <div id="wrapper">
        <!-- Sidebar-->
        @auth
        <div class="border-end bg-white" id="sidebar-wrapper">
            <div class="list-group list-group-flush">
                <a class="list-group-item list-group-item-action p-3 {{ Request::is('/') ? 'active' : '' }}" href="/">
                    <i class="fas fa-home align-text-bottom mr-2"></i> Dashboard
                </a>
                <a class="list-group-item list-group-item-action p-3 {{ Request::is('categories*') ? 'active' : '' }}" href="/categories">
                    <i class="fas fa-list mr-2"></i> Kategori
                </a>
                <a class="list-group-item list-group-item-action p-3 {{ Request::is('materies*') ? 'active' : '' }}" href="/materies">
                    <i class="fas fa-book"></i> Materi
                </a>
                <a class="list-group-item list-group-item-action p-3 {{ Request::is('histories*') ? 'active' : '' }}" href="/histories">
                    <i class="fas fa-clock"></i> Riwayat
                </a>
                <a class="list-group-item list-group-item-action p-3 {{ Request::is('courses*') ? 'active' : '' }}" href="/courses">
                    <i class="fas fa-layer-group"></i> Daftar Kursus
                </a>
                <a class="list-group-item list-group-item-action p-3 {{ Request::is('students*') ? 'active' : '' }}" href="/students">
                    <i class="fas fa-users"></i> Murid
                </a>                
            </div>
        </div>
        
        @endauth
        <!-- Page content wrapper-->
        <div id="page-content-wrapper">
            <!-- Top navigation-->
            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm fixed-top">
                <div class="container">
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
            // Inisialisasi Feather Icons
            feather.replace();
        });
    </script>    
</body>
</html>
