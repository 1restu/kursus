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
    <!-- Bootstrap & CSS Dependencies -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.5/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/iconly@1.0.0-beta2/css/iconly.css">
    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    {{-- @vite(['resources/sass/app.scss']) --}}
    <style>
        html, body {
            height: 100%;
            font-family: 'Ubuntu', sans-serif;
            margin: 0;
        }
        .gfg {
            height: 50px;
            width: 50px;
        }
        .navbar {
            margin-left: 250px; /* Sesuaikan dengan lebar sidebar */
            z-index: 1040; /* Lebih rendah dari sidebar */
            width: calc(100% - 250px); /* Lebar menyesuaikan */
            position: fixed;
            top: 0;
            right: 0;
        }
        #bdSidebar {
            z-index: 1010; /* Lebih tinggi dari z-index default header */
            position: fixed; /* Buat sidebar tetap */
            top: 0;
            bottom: 0;
            width: 250px; /* Lebar sidebar */
            background-color: #333; /* Warna latar belakang sidebar */
            overflow-y: auto; /* Agar sidebar bisa di-scroll jika konten panjang */
        }
        .dropdown-menu {
            z-index: 1080; /* Tambahkan z-index ke dropdown untuk memastikan di atas elemen lain */
            position: absolute;
        }   
        .mynav {
            color: #fff;
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .mynav li a {
            color: #fff;
            text-decoration: none;
            width: 100%;
            display: block;
            border-radius: 5px;
            padding: 8px 5px;
            transition: background 0.3s ease;
        }
        .mynav li a.active {
            background-color: rgba(255, 255, 255, 0.2); /* Latar belakang untuk link aktif */
            font-weight: bold; /* Membuat teks link lebih tebal */
            color: #ffffff; /* Warna teks link aktif */
            border-left: 4px solid #ffffff; /* Garis kiri untuk menandai link aktif */
            padding-left: 12px; /* Menambahkan padding di sebelah kiri */
        }
        .mynav li a:hover {
            background: rgba(255, 255, 255, 0.1); /* Latar belakang saat link di-hover */
            color: #ffffff; /* Warna teks saat hover */
            text-decoration: none; /* Menghilangkan garis bawah saat hover */
        }
        .mynav li a i {
            width: 25px;
            text-align: center;
        }
        .notification-badge {
            background-color: rgba(255, 255, 255, 0.7);
            float: right;
            color: #222;
            font-size: 14px;
            padding: 0px 8px;
            border-radius: 2px;
        }
        .content-area {
            margin-left: 250px; /* Sesuaikan dengan lebar sidebar */
            padding: 20px;
            width: calc(100% - 250px); /* Sesuaikan lebar konten */
            overflow-y: auto; /* Mengatasi konten yang tertimpa */
            position: relative;
            z-index: 1020; /* Lebih rendah dari sidebar */
        }
        .my-dropdown {
            border: 1px solid #555; /* Border untuk rectangle */
            border-radius: 20px; /* Rounded rectangle */
            padding: 0px 10px; /* Ruang di sekitar konten */
            display: flex;
            align-items: center; /* Sejajarkan konten secara vertikal */
        }
        .my-nav-icon {
            font-size: 18px;
            color: #555;
            margin-right: 5px; /* Jarak antara ikon dan ul */
            margin-left: 5px; /* Jarak antara ikon dan ul */
        }
        .my-dropdown .dropdown-menu {
            border-radius: 15px; /* Rounded rectangle untuk menu dropdown */
            border: 1px solid #555;
        }
        .navbar-toggler-icon {
            color: #007bff;
        }
        main {
            margin-left: 250px; /* Sesuaikan dengan lebar sidebar */
            width: calc(100% - 250px); /* Atur ulang lebar konten */
            position: relative;
            z-index: 1020; /* Lebih rendah dari sidebar */
            padding: 20px; /* Menambahkan padding untuk ruang konten */
        }
        .login-page .navbar,
        .login-page .content-area,
        .login-page main {
            margin-left: 0;
            width: 100%;
            padding: 0;
        }
        .login-page main {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin-left: 0;
            width: 100%;
            padding: 0;
        }
    </style>
</head>
<body @if(Route::is('login')) class="login-page" @endif>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <div id="app">
        @if(!Route::is('login'))
            @include('layouts.navbar')
        @endif
        <div class="container-fluid p-0 d-flex h-100 shadow-sm">
            @if(!Route::is('login'))
                @include('layouts.sidebar')
            @endif
            <div class="bg-light flex-fill">
                <div class="p-2 d-md-none d-flex text-white bg-success">
                    <a href="#" class="text-white" data-bs-toggle="offcanvas" data-bs-target="#bdSidebar">
                        <i class="fa-solid fa-bars"></i>
                    </a>
                    <span class="ms-3">GFG Portal</span>
                </div>
                <main class="p-4">
                    <nav style="--bs-breadcrumb-divider:'>';font-size:14px">
                        {{-- <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <i class="fa-solid fa-house"></i>
                            </li>
                            <li class="breadcrumb-item">Konten Pembelajaran</li>
                            <li class="breadcrumb-item">Halaman Berikutnya</li>
                        </ol> --}}
                    </nav>
                    <hr>
                    <div class="row">
                        {{-- <div class="col">
                            <p>Konten halaman di sini</p>
                        </div> --}}
                    </div>
                    @yield('content')
                </main>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6IfUX/WbWhiCZhOV+kwtVsJjvsb+8HYpK1gFk1O2OsPSpGgnmlKq" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/2.1.5/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.5/js/dataTables.bootstrap5.js"></script>
    @stack('scripts')
</body>
</html>