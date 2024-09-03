@extends('layouts.app')

@section('title', 'Halaman Materi')
@section('content')
@php
    $breadcrumbSecond = 'Halaman Daftar Materi';
@endphp

<!-- Font Awesome (versi yang sama) -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />

<!-- jQuery -->
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!-- Bootstrap 5 (yang sama) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script> --}}
<style>
    body {
        background-color: #f8f9fa;
        margin-top: 20px;
    }
    .file_manager .file {
        padding: 0 !important;
        border-radius: 8px;
        overflow: hidden;
        background: #fff;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        position: relative;
    }
    .file_manager .file:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    .file_manager .file .icon {
        text-align: center;
        padding: 20px;
        font-size: 48px;
        color: #6c757d;
    }
    .file_manager .file .icon i {
        vertical-align: middle;
    }
    .file_manager .file .file-name {
        padding: 15px;
        border-top: 1px solid #dee2e6;
        text-align: center;
    }
    .file_manager .file .file-name p {
        margin-bottom: 5px;
        font-weight: 500;
    }
    .file_manager .file .file-name small {
        display: block;
        color: #6c757d;
    }
    .file_manager .file .dropdown-menu {
        border: 1px solid #555;
        border-radius: 15px;
    }
    .file_manager .file .dropdown-item {
        display: flex;
        align-items: center;
        padding: 10px;
    }
    .file_manager .file .dropdown-item i {
        margin-right: 10px;
    }
    .file_manager .file .dropdown-toggle::after {
        display: none; /* Hapus panah default */
    }
    .file_manager .file .dropdown {
        position: absolute;
        top: 10px;
        right: 10px;
    }
</style>

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
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<h4 class="text-center font-weight-bold mb-4">MATERI</h4>

<div id="main-content" class="file_manager container">
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('materies.create') }}" class="btn btn-primary">Tambah Materi</a>
    </div>
    <div class="row">
        @foreach ($materies as $matery)
            @php
                $filePath = public_path("assets/files/$matery->file_mtr");
                $fileSize = file_exists($filePath) ? filesize($filePath) / 1048576 : 0;
                $fileName = pathinfo($matery->file_mtr, PATHINFO_EXTENSION);
            @endphp
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="card file">
                    <div class="icon">
                        @if (in_array($fileName, ['pdf']))
                            <i class="fa-solid fa-file-pdf text-danger"></i>
                        @elseif (in_array($fileName, ['doc', 'docx']))
                            <i class="fa-solid fa-file-word text-primary"></i>
                        @elseif (in_array($fileName, ['txt']))
                            <i class="fa-solid fa-file-lines text-warning"></i>
                        @else
                            <i class="fa-solid fa-file text-muted"></i>
                        @endif
                    </div>
                    <div class="file-name">
                        <p class="text-muted">{{ $matery->nama_mtr }}</p>
                        <small>Tipe File: {{ $fileName }}</small>
                        <small>Ukuran: {{ number_format($fileSize, 2) }} MB</small>
                        <small class="text-muted">{{ $matery->created_at->translatedFormat('d F Y') }}</small>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-light btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <i data-feather="more-horizontal"></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li><a class="dropdown-item" href="{{ route('materies.show', $matery->id) }}"><i data-feather="eye"></i> Lihat</a></li>
                            <li><a class="dropdown-item" href="{{ route('materies.edit', $matery->id) }}"><i data-feather="edit"></i> Edit</a></li>
                            <li>
                                <form action="{{ route('materies.destroy', $matery->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus materi ini?');">
                                        <i data-feather="trash-2"></i> Hapus
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        setTimeout(function() {
            let alertElement = document.querySelector('.alert');
            if (alertElement) {
                alertElement.classList.remove('show');
                alertElement.classList.add('fade');
                setTimeout(() => alertElement.remove(), 600);
            }
        }, 5000); 

        feather.replace(); // Ganti ikon dengan Feather
    });
</script>

@endsection