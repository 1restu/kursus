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
            <div class="card" style="box-shadow: 2px rgba(0, 0, 0, 0.1);">
                <div class="card-header">{{ __('Kursus Baru') }}</div>

                <div class="card-body">
                    <form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Input Nama Materi -->
                        {{-- <div class="form-group">
                            <label for="materi">Kursus</label>
                            <select name="id_mtr" id="materi" class="form-control">
                                <option value="">Pilih Materi</option>
                                @foreach($materies as $matery)
                                    <option value="{{ $matery->id }}">{{ $matery->nama_mtr }}</option>
                                @endforeach
                            </select>
                        </div> --}}

                        <div class="form-group">
                            <label for="materi">Murid</label>
                            <select name="id_mrd" id="materi" class="form-control">
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

                        <div class="form-group mb-2">
                            <label for="tanggal">Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai" id="tanggal" class="form-control" value="{{ old('tanggal_selesai') }}">
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
