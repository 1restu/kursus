@extends('layouts.app')

@section('title', 'Halaman Materi')
@section('content')

<!-- Font Awesome (versi yang sama) -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />

<!-- jQuery -->
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!-- Bootstrap 5 (yang sama) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script> --}}

<style>
    body {
        background-color: #f4f7f6;
        margin-top: 20px;
    }
    .file_manager .file a:hover .hover,
    .file_manager .file .file-name small {
        display: block;
    }
    .file_manager .file {
        padding: 0 !important;
    }
    .file_manager .file .icon {
        text-align: center;
    }
    .file_manager .file {
        position: relative;
        border-radius: .55rem;
        overflow: hidden;
    }
    .file_manager .file .image,
    .file_manager .file .icon {
        max-height: 180px;
        overflow: hidden;
        background-size: cover;
        background-position: top;
    }
    .file_manager .file .hover {
        position: absolute;
        right: 10px;
        top: 10px;

        display: none;
        transition: all 0.2s ease-in-out;
    }
    .file_manager .file a:hover .hover {
        transition: all 0.2s ease-in-out;
    }
    .file_manager .file .icon {
        padding: 15px 10px;
        display: table;
        width: 100%;
    }
    .file_manager .file .icon i {
        display: table-cell;
        font-size: 30px;
        vertical-align: middle;
        color: #777;
        line-height: 100px;
    }
    .file_manager .file .file-name {
        padding: 10px;
        border-top: 1px solid #ebe5e5;
    }
    .file_manager .file .file-name small .date {
        float: right;
    }
    .folder {
        padding: 20px;
        display: block;
        color: #777;
    }
    @media only screen and (max-width: 992px) {
        .file_manager .nav-tabs {
            padding-left: 0;
            padding-right: 0;
        }
        .file_manager .nav-tabs .nav-item {
            display: inline-block;
        }
    }
    .card {
        background: #fff;
        transition: .5s;
        border: 0;
        margin-bottom: 30px;
        border-radius: .55rem;
        position: relative;
        width: 100%;
        box-shadow: 0 1px 2px 0 rgb(0 0 0 / 10%);
    }
    a:hover {
        text-decoration: none;
    }
    .file_manager .file:hover .hover {
    display: block; /* Tampilkan elemen saat hover */
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
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
<h4 class="text-center font-weight-bold mb-4">MATERI</h4>
<div id="main-content" class="file_manager">
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('materies.create') }}" class="btn btn-primary mb-3">Tambah Materi</a>
    </div>
    <div class="container">
        <div class="row clearfix">
            @foreach ($materies as $matery)
                @php
                    $filePath = public_path("assets/files/$matery->file_mtr");
                    $fileSize = file_exists($filePath) ? filesize($filePath) / 1048576 : 0;
                    $fileName = pathinfo($matery->file_mtr, PATHINFO_EXTENSION);
                @endphp
                <div class="col-lg-3 col-md-4 col-sm-12">
                    <div class="card">
                        <div class="file">
                            <div class="hover">
                                <!-- Tombol untuk memicu modal -->

                                <a href="{{ route('materies.show', $matery->id) }}" class="btn btn-icon btn-primary">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <!-- Sertakan file modal -->
            
                                {{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#detailModal{{ $matery->id }}">
                                    <i class="fa fa-eye"></i>
                                </button> --}}

                                <!-- Tombol Edit -->
                                <a href="{{ route('materies.edit', $matery->id) }}" class="btn btn-icon btn-warning">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <!-- Tombol Delete -->
                                <form action="{{ route('materies.destroy', $matery->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-icon btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus materi ini?');">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                            <div class="icon badge-secondary">
                                @if (in_array($fileName, ['pdf']))
                                    <i class="fa fa-file-pdf-o text-danger"></i>
                                @elseif (in_array($fileName, ['doc', 'docx']))
                                    <i class="fa fa-file-word-o text-primary"></i>
                                @elseif (in_array($fileName, ['txt']))
                                    <i class="fa fa-file-text text-warning"></i>
                                @else
                                    <i class="fa fa-file text-muted"></i>
                                @endif
                            </div>
                            <div class="file-name">
                                <p class="m-b-5 text-muted">{{ $matery->nama_mtr }}</p>
                                <small>Tipe File: {{ $fileName }}</small>
                                <small>Ukuran: {{ number_format($fileSize, 2) }} MB <span class="date text-muted">{{ $matery->created_at->translatedFormat('d F Y') }}</span></small>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
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
    });

    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(event) {
            if (!confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                event.preventDefault();
            }
        });
    });
</script>

@endsection
