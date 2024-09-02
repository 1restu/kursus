<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm" style="--bs-breadcrumb-divider:'>';font-size:14px;">
    <div class="container">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                {{-- <a href="{{ url('/') }}"> --}}
                    <i class="fa-solid fa-house"></i> Home
                {{-- </a> --}}
            </li>
            <li class="breadcrumb-item">Konten Pembelajaran</li>
            <li class="breadcrumb-item active" aria-current="page">Halaman Berikutnya</li>
        </ol>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Sisi Kiri Navbar -->
            <ul class="navbar-nav me-auto">
                <!-- Kosongkan jika tidak diperlukan tambahan item -->
            </ul>

            <!-- Sisi Kanan Navbar -->
            <div class="navbar-nav ms-auto my-dropdown d-flex align-items-center">
                <i class="fa-solid fa-user my-nav-icon"></i> <!-- Ikon user disamping kiri ul -->
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
    </div>
</nav>