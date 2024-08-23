@extends('layouts.app')

@section('content')

<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />

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
        border-top: 1px solid #f7f7f7;
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

<div id="main-content" class="file_manager">
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('materies.create') }}" class="btn btn-primary mb-3">Tambah Materi</a>
    </div>
    <div class="container">
        <div class="row clearfix">
            @foreach ($materi as $matery)
                @php
                    // Ekstrak ekstensi dari nama file
                    $fileName = pathinfo($matery->file_mtr, PATHINFO_EXTENSION);
                    // $fileSizeInMB = pathinfo($matery->file_mtr);
                    
                    $fileSize = filesize(public_path("assets/files/$matery->file_mtr"))/ 1048576;
                @endphp
                <div class="col-lg-3 col-md-4 col-sm-12">
                    <div class="card">
                        <div class="file">
                            {{-- <a href="javascript:void(0);"> --}}
                                <div class="hover">
                                    <a href="{{ route('materies.show', $matery->id) }}" class="btn btn-icon btn-primary">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    
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
                                <div class="icon">
                                    <div class="icon">
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
                                </div>
                                <div class="file-name">
                                    <p class="m-b-5 text-muted">{{ $matery->nama_mtr }}</p>
                                    <small>Size: {{ number_format($fileSize, 2) }} MB <span class="date text-muted">{{ $matery->created_at->format('M d, Y') }}</span></small>
                                </div>
                            {{-- </a> --}}
                        </div>
                    </div>
                </div> 
            @endforeach
        </div>
    </div>
</div>

@endsection
