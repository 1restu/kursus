@extends('layouts.app')

@section('title', 'Tambah Materi')
@section('content')
@php
    $breadcrumbSecond = 'Halaman Tambah Materi';
@endphp
<div id="main-content" class="file_manager">
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


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" style="box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);">
                <div class="card-header">{{ __('Upload Materi Baru') }}</div>

                <div class="card-body">
                    <form action="{{ route('materies.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Input Nama Materi -->
                        <div class="form-group mb-2">
                            <label for="nama_materi">{{ __('Nama Materi') }}</label>
                            <input type="text" class="form-control" id="nama_materi" name="nama_mtr" placeholder="Masukkan nama materi" value="{{ old('nama_mtr') }}">
                        </div>
                        
                        <div class="form-group mb-2">
                            <label for="kategori">Kategori</label>
                            <select name="id_ktg" id="kategori" class="form-control">
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->nama_ktg }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Input Deskripsi -->
                        <div class="form-group mb-2">
                            <label for="deskripsi">{{ __('Deskripsi') }}</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" placeholder="Masukkan deskripsi materi">{{ old('deskripsi') }}</textarea>
                        </div>

                        <!-- Input File Materi -->
                        <div class="form-group mb-2">
                            <label for="formFile">{{ __('File Materi') }}</label>
                            <br><small class="text-danger">{{ __('Upload file dalam bentuk PDF, DOC, DOCX dan TXT') }}</small>
                            <br><input type="file" class="form-control" id="formFile" name="file_mtr">
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary mt-2">{{ __('Upload Materi') }}</button>
                    </form>
                </div>
            </div>
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
