{{-- <form action="{{ route('regists.store') }}" method="POST">
    @csrf
    <!-- Field lain -->
    <input type="hidden" name="id_krs" value="{{ $id_krs }}">
    <!-- Tombol submit -->
    <button type="submit" class="btn btn-primary">Simpan</button>
</form> --}}
@extends('layouts.app')

@section('content')
@php
    $breadcrumbSecond = 'Halaman Pendaftaran Kursus';
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
                <div class="card-header">{{ __('Tambah Pendaftaran') }}</div>

                <div class="card-body">
                    <form action="{{ route('regists.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Input Nama Materi -->
                        <div class="form-group mb-2">
                            {{-- <label for="nama_kursus">{{ __('Nama Kursus') }}</label> --}}
                            <input type="hidden" name="id_krs" value="{{ $id_krs }}" id="nama_kursus" class="form-control-plaintext">
                        </div>
                        
                        <div class="form-group mb-2">
                            <label for="murid">Murid</label>
                            <select name="id_mrd" id="murid" class="form-control">
                                <option value="">Pilih Murid</option>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}">{{ $student->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-2">
                            <label for="tanggal">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" id="tanggal" class="form-control" value="{{ old('tanggal_mulai') }}">
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary mt-2">{{ __('Tambah') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
//   document.addEventListener("DOMContentLoaded", function() {
//       setTimeout(function() {
//           let alertElement = document.querySelector('.alert');
//           if (alertElement) {
//               alertElement.classList.remove('show');
//               alertElement.classList.add('fade');
//               setTimeout(() => alertElement.remove(), 600);
//           }
//       }, 5000); 
//   });
  document.querySelectorAll('.delete-form').forEach(form => {
      form.addEventListener('submit', function(event) {
          if (!confirm('Apakah Anda yakin ingin menghapus data ini?')) {
              event.preventDefault();
          }
      });
  });
</script>
@endsection
