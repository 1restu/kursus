@extends('layouts.app')

@section('title', 'Detail Materi')
@section('content')
@php
    $breadcrumbSecond = 'Halaman Detail Materi';
@endphp
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ __('Detail Materi') }}
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h5>Nama:</h5>
                        <p class="form-control-plaintext">{{ $materies->nama_mtr }}</p>
                    </div>
                    <div class="mb-3">
                        <h5>Kursus:</h5>
                            @if($materies->kursus)
                                <p class="form-control-plaintext">Materi ini digunakan pada kursus: {{ $materies->kursus->nama_krs }}</p>
                            @else
                                <p class="form-control-plaintext">Materi ini tidak digunakan pada kursus apapun.</p>
                            @endif
                    </div>
                    <div class="mb-3">
                        <h5>Deskripsi:</h5>
                        <p class="form-control-plaintext">{{ $materies->deskripsi }}</p>
                    </div>
                    <div class="mb-3">
                        <h5>Kategori:</h5>
                        <p class="form-control-plaintext">{{ $materies->kategori->nama_ktg }}</p>
                    </div>
                    <div class="mb-3">
                        <h5>File:</h5>
                        <p class="form-control-plaintext">{{ $materies->original_file_mtr }}</p>
                    </div>
                    <div class="mb-3">
                        <h5>Ditambahkan:</h5>
                        <p class="form-control-plaintext">{{ $materies->created_at->translatedFormat('d F Y') }}</p>
                    </div>
                    <div class="mb-3">
                        <h5>Ukuran File:</h5>
                        <p class="form-control-plaintext">{{ number_format(filesize(public_path("assets/files/{$materies->file_mtr}")) / 1048576, 2) }} MB</p>
                    </div>                    
                    <div class="d-flex justify-content-between">
                        <a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>
                        <a href="{{ route('materi.download', $materies->id) }}" class="btn btn-primary">Download File</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
