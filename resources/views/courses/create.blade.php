@extends('layouts.app')

@section('content')

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
            <div class="card">
                <div class="card-header">{{ __('Kursus Baru') }}</div>

                <div class="card-body">
                    <form action="{{ route('courses.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Input Nama Materi -->
                        <div class="form-group">
                            <label for="nama_kursus">{{ __('Nama Kursus') }}</label>
                            <input type="text" class="form-control" id="nama_kursus" name="nama_krs" placeholder="Masukkan nama kursus" value="{{ old('nama_krs') }}">
                        </div>

                        <div class="form-group">
                            <label for="deskripsi">{{ __('Deskripsi') }}</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" placeholder="Masukkan deskripsi kursus">{{ old('deskripsi') }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="materi">Materi</label>
                            <select name="id_mtr" id="materi" class="form-control">
                                <option value="">Pilih Materi</option>
                                @foreach($materies as $matery)
                                    <option value="{{ $matery->id }}">{{ $matery->nama_mtr }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="gambar">{{ __('Gambar') }}</label>
                            <input type="file" class="form-control-file" id="gambar" name="gambar">
                        </div>

                        <div class="form-group">
                            <label for="biaya">{{ __('Biaya Kursus') }}</label>
                            <input type="number" class="form-control" id="biaya" name="biaya_krs" placeholder="Masukkan biaya kursus" value="{{ old('biaya_kursus') }}">
                        </div>

                        <div class="form-group">
                            <label for="durasi">{{ __('Durasi Kursus') }}</label>
                            <input type="number" class="form-control" id="durasi" name="durasi" placeholder="Masukkan durasi kursus" value="{{ old('durasi') }}">
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary">{{ __('Tambah') }}</button>
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
