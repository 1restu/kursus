@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ __('Detail Materi') }}
                </div>
                <div class="card-body">
                    <form>
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" readonly value="{{ $materies->nama_mtr }}">
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" rows="4" readonly>{{ $materies->deskripsi }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="kategori" class="form-label">Kategori</label>
                            <input type="text" class="form-control" id="kategori" readonly value="{{ $materies->kategori->nama_ktg }}">
                        </div>
                        <div class="mb-3">
                            <label for="file" class="form-label">File</label>
                            <input type="text" class="form-control" id="file" readonly value="{{ $materies->file_mtr }}">
                        </div>
                        <div class="mb-3">
                            <label for="file" class="form-label">Ditambahkan</label>
                            <input type="text" class="form-control" id="file" readonly value="{{ $materies->created_at->format('d M Y, H:i') }}">
                        </div>                        
                    </form>
                    <div class="d-flex justify-content-between">
                        <a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>
                        <a href="/assets/files/{{ $materies->file_mtr }}" class="btn btn-primary" target="_blank">Download File</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
