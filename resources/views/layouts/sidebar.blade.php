<div id="bdSidebar" class="d-flex flex-column flex-shrink-0 p-3 bg-success text-white offcanvas-md offcanvas-start shadow-sm">
    <a href="#" class="navbar-brand"></a>
    <div class="sidebar-heading text-center py-1">
        <img src="{{ asset('assets/logo/lesson_15399113.png') }}" alt="Heading Image" style="max-width: 50%; height: auto;">
    </div>
    <hr class="mt-2">
    <ul class="mynav nav nav-pills flex-column mb-auto">
        <li class="nav-item mb-1">
            <a href="/" class="{{ Request::is('/') ? 'active' : '' }}">
                <i class="fas fa-home"></i>Dashboard
            </a>
        </li>
        <li class="nav-item mb-1">
            <a href="/categories" class="{{ Request::is('categories*') ? 'active' : '' }}">
                <i class="fas fa-list"></i>Kategori
            </a>
        </li>
        <li class="nav-item mb-1">
            <a href="/students"class="{{ Request::is('students*') ? 'active' : '' }}">
                <i class="fas fa-users"></i>Murid
            </a>
        </li>
        <li class="nav-item mb-1">
            <a href="/materies" class="{{ Request::is('materies*') ? 'active' : '' }}">
                <i class="fas fa-book"></i>Materi
            </a>
        </li>
        <li class="nav-item mb-1">
            <a href="/courses" class="{{ Request::is('courses*') ? 'active' : '' }}">
                <i class="fas fa-layer-group"></i>Daftar Kursus
            </a>
        </li>
        <li class="nav-item mb-1">
            <a href="/histories" class="{{ Request::is('histories*') ? 'active' : '' }}">
                <i class="fas fa-clock"></i>Riwayat
            </a>
        </li>
    </ul>
    <hr>
    <div class="d-flex">
        {{-- <i class="fa-solid fa-book me-2 mt2 bold"></i> --}}
        <span>
            <h2 class="mt-1 mb-0 text-center" style="font-family: 'Times New Roman', serif;">
                Kursus Online
            </h2>
        </span>
    </div>
</div>