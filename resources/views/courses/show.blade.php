@extends('layouts.app')

@section('content')
@php
    $breadcrumbSecond = 'Halaman Detail Kursus';
@endphp
<style>
    body {
        background-color: #f5f5f5;
    }

    .hedding {
        font-size: 20px;
        color: #ab8181;
    }

    .main-section {
        position: relative;
        left: 50%;
        right: 50%;
        transform: translate(-50%, 5%);
    }

    .left-side-product-box img {
        width: 100%;
    }

    .right-side-pro-detail span {
        font-size: 15px;
    }

    .right-side-pro-detail p {
        font-size: 25px;
        color: #a1a1a1;
    }

    .right-side-pro-detail .price-pro {
        color: #E45641;
    }

    .right-side-pro-detail .tag-section {
        font-size: 18px;
        color: #5D4C46;
    }

    @media (min-width:360px) and (max-width:640px) {
        .pro-box-section .pro-box img {
            height: auto;
        }
    }

    .table-responsive {
        margin: 30px 0;
    }

    .table-wrapper {
        min-width: 1000px;
        background: #fff;
        padding: 20px;
        box-shadow: 0 1px 1px rgba(0,0,0,.05);
    }

    .table-title {
        padding-bottom: 10px;
        margin: 0 0 10px;
        min-width: 100%;
    }

    .table-title h2 {
        margin: 8px 0 0;
        font-size: 22px;
    }

    table.table td i {
        font-size: 19px;
    } 

    .material-text {
    font-weight: normal;
    margin-left: 8px; /* Adjust this value to control spacing */
}
</style>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<div class="container">
    <div class="col-lg-8 border p-3 main-section bg-white">
        <div class="row hedding m-0 pl-3 pt-0 pb-3">
            Detail Kursus
        </div>
        <div class="row m-0">
            <div class="col-lg-4 left-side-product-box pb-3">
                <a href="{{ asset('assets/images/' . $course->gambar) }}" target="_blank">
                    <img src="{{ asset('assets/images/' . $course->gambar) }}" class="border p-3" alt="...">
                </a>
            </div>
            <div class="col-lg-8">
                <div class="right-side-pro-detail border p-3 m-0">
                    <div class="row">
                        <div class="col-lg-12">
                            <p class="m-0 p-0">{{ $course->nama_krs }}</p>
                        </div>
                        <div class="col-lg-12">
                            <p class="m-0 p-0 price-pro">{{ 'Rp ' . number_format($course->biaya_krs, 0, ',', '.') }}</p>
                            <hr class="p-0 m-0">
                        </div>
                        <div class="col-lg-12 pt-2">
                            <h5>Deskripsi</h5>
                            <span>{{ $course->deskripsi }}</span>
                            <hr class="m-0 pt-2 mt-2">
                        </div>
                        <div class="col-lg-12 pt-2">
                            <p class="tag-section"><strong>Durasi : {{ $course->jam }} Jam/{{ $course->durasi }} Hari</strong>
                        </div>
                        <div class="col-lg-12 pt-2">
                            <h5>Materi Kursus</h5>
                            @foreach ($course->materi as $matery)
                                @php
                                    $fileName = pathinfo($matery->file_mtr, PATHINFO_EXTENSION);
                                @endphp
                                @if (in_array($fileName, ['pdf']))
                                    <i class="fa fa-file-pdf-o text-danger"></i> <span class="material-text">{{ $matery->nama_mtr }}</span><br>
                                @elseif (in_array($fileName, ['doc', 'docx']))
                                    <i class="fa fa-file-word-o text-primary"></i> <span class="material-text">{{ $matery->nama_mtr }}</span><br>
                                @elseif (in_array($fileName, ['txt']))
                                    <i class="fa fa-file-text text-warning"></i> <span class="material-text">{{ $matery->nama_mtr }}</span><br>
                                @else
                                    <i class="fa fa-file text-muted"></i> <span class="material-text">{{ $matery->nama_mtr }}</span><br>
                                @endif
                            @endforeach
                        </div>
                        <div class="col-lg-12 mt-3">
                            <div class="row">
                                <div class="col-lg-6 pb-2">
                                    <a href="{{ route('courses.edit', $course->id) }}" class="btn btn-warning w-100">{{ __('Edit') }}</a>
                                </div>
                                <div class="col-lg-6">
                                    <!-- Tombol Delete -->
                                    <form action="{{ route('courses.destroy', $course->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Apakah Anda yakin ingin menghapus kursus ini?');">{{ __('Hapus') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('partials.regist', ['course_id' => $course->id, 'regists' => $regists])
</div>
@endsection
