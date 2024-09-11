@extends('layouts.app')

@section('content')
@php
    $breadcrumbSecond = 'Halaman Daftar Kursus';
@endphp
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
<style>
    .card {
        transition: transform 0.3s ease-in-out;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    .full-center-alert {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
    width: auto; /* Lebar otomatis sesuai konten */
    max-width: 400px; /* Batas maksimal lebar */
}

</style>
<h4 class="text-center font-weight-bold m-4">KURSUS</h4>
<div class="d-flex justify-content-between mb-3">
    <a href="{{ route('courses.create') }}" class="btn btn-primary mb-3">Tambah Kursus</a>
    <form action="{{ route('courses.index') }}" method="GET" class="d-flex">
        <input type="text" name="search" class="form-control me-2" placeholder="Cari Kursus..." value="{{ request()->get('search') }}">
        <button type="submit" class="btn btn-secondary">Cari</button>
    </form>
</div>

<div class="row row-cols-1 row-cols-md-3 g-4 mx-auto position-relative" id="content" style="min-height: 400px;">
    @forelse($courses as $cours)
        <div class="col">
            <div class="card h-60">
                <div style="height: 150px; overflow: hidden;">
                    <img src="{{ asset('assets/images/' . $cours->gambar) }}" class="card-img-top" alt="{{ $cours->nama_krs }}" style="height: 100%; object-fit: cover;">
                </div>
                <div class="card-body bg-light mb-2">
                    <h5 class="card-title">{{ $cours->nama_krs }}</h5>
                    <p class="card-text text-truncate" style="max-height: 3.6em; overflow: hidden; line-height: 1.2em;">
                        {{ $cours->deskripsi }}
                    </p>
                    <a href="{{ route('courses.show', $cours->id) }}" class="btn btn-info">Detail</a>
                </div>
            </div>
        </div>
    @empty
        <div class="full-center-alert">
            <div class="alert alert-warning">
                Tidak ada data
            </div>
        </div>
    @endforelse
</div>
@endsection
<script>
    document.addEventListener("DOMContentLoaded", function() {
    setTimeout(function() {
        let alertElements = document.querySelectorAll('.alert.alert-dismissible'); // Hanya sembunyikan alert yang bisa ditutup
        alertElements.forEach(function(alertElement) {
            if (alertElement) {
                alertElement.classList.remove('show');
                alertElement.classList.add('fade');
                setTimeout(() => alertElement.remove(), 600);
            }
        });
    }, 5000);

    feather.replace(); // Ganti ikon dengan Feather
});
</script>

