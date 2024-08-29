@extends('layouts.app')

@section('content')
    
<style>
    body {
    font-family: 'Roboto Condensed', sans-serif;
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

    .left-side-product-box .sub-img img {
        margin-top: 5px;
        width: 83px;
        height: 100px;
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

    .pro-box-section .pro-box img {
        width: 100%;
        height: 200px;
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
.search-box {
    position: relative;        
    float: right;
}
.search-box input {
    height: 34px;
    border-radius: 20px;
    padding-left: 35px;
    border-color: #ddd;
    box-shadow: none;
}
.search-box input:focus {
    border-color: #3FBAE4;
}
.search-box i {
    color: #a0a5b1;
    position: absolute;
    font-size: 19px;
    top: 8px;
    left: 10px;
}
table.table tr th, table.table tr td {
    border-color: #e9e9e9;
}
table.table-striped tbody tr:nth-of-type(odd) {
    background-color: #fcfcfc;
}
table.table-striped.table-hover tbody tr:hover {
    background: #f5f5f5;
}
table.table th i {
    font-size: 13px;
    margin: 0 5px;
    cursor: pointer;
}
table.table td:last-child {
    width: 130px;
}
table.table td a {
    color: #a0a5b1;
    display: inline-block;
    margin: 0 5px;
}
table.table td a.view {
    color: #03A9F4;
}
table.table td a.edit {
    color: #FFC107;
}
table.table td a.delete {
    color: #E34724;
}
table.table td i {
    font-size: 19px;
} 
</style>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> --}}
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<div class="container">
    <div class="col-lg-8 border p-3 main-section bg-white">
        <div class="row hedding m-0 pl-3 pt-0 pb-3">
            Detail Kursus
        </div>
        <div class="row m-0">
            <div class="col-lg-4 left-side-product-box pb-3">
                <img src="{{ asset('assets/images/' . $course->gambar) }}" class="border p-3" alt="...">
            </div>
            <div class="col-lg-8">
                <div class="right-side-pro-detail border p-3 m-0">
                    <div class="row">
                        <div class="col-lg-12">
                            {{-- @foreach ($categories as $category)
                                <span>{{ $category->nama_ktg }}</span>
                                @break
                            @endforeach --}}
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
                            {{-- @foreach ($course->materi as $matery) --}}
                                {{-- {{ $matery }} --}}
                                @php
                                    $matery=$course->materi;
                                    $fileName = pathinfo($matery->file_mtr, PATHINFO_EXTENSION);
                                @endphp
                                @if (in_array($fileName, ['pdf']))
                                    <i class="fa fa-file-pdf-o text-danger">{{ $course->materi->nama_mtr }}</i>
                                @elseif (in_array($fileName, ['doc', 'docx']))
                                    <i class="fa fa-file-word-o text-primary">  {{ $course->materi->nama_mtr }}</i>
                                @elseif (in_array($fileName, ['txt']))
                                    <i class="fa fa-file-text text-warning">{{ $course->materi->nama_mtr }}</i>
                                @else
                                    <i class="fa fa-file text-muted">{{ $course->materi->nama_mtr }}</i>
                                @endif
                            {{-- @endforeach --}}
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
                                        <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Apakah Anda yakin ingin menghapus materi ini?');">{{ __('Hapus') }}
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
    @include('partials.regist',['course_id' => $course->id, 'regists' => $regists])
</div>
@endsection
