@extends('layouts.app')

@section('title', 'Ubah Materi')

@section('content')
<div class="container">
    <div class="d-flex justify-content-center align-items-center flex-column">
        <div class="col-lg-8">

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show error-message" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form class="border p-4 rounded bg-light" style="width: 100%; max-width: 500px;" action="{{ route('materies.update', $materi->id) }}" method="POST" enctype="multipart/form-data">
                <h2 class="mb-4">Edit Data Materi</h2>
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="nama_materi">{{ __('Nama Materi') }}</label>
                    <input type="text" class="form-control" id="nama_materi" name="nama_mtr" value="{{ old('nama_mtr', $materi->nama_mtr) }}">
                </div>
                
                <div class="form-group">
                    <label for="kategori">Kategori</label>
                    <select name="id_ktg" id="kategori" class="form-control">
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $category->id == old('id_ktg', $materi->id_ktg) ? 'selected' : '' }}>
                                {{ $category->nama_ktg }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Input Deskripsi -->
                <div class="form-group">
                    <label for="deskripsi">{{ __('Deskripsi') }}</label>
                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi', $materi->deskripsi) }}</textarea>
                </div>

                <!-- Input File Materi -->
                <div class="form-group">
                    <label for="file_materi">{{ __('File Materi') }}</label>
                    <input type="file" class="form-control-file" id="file_materi" name="file_mtr">
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        setTimeout(function() {
            let errorAlerts = document.querySelectorAll('.error-message');
            errorAlerts.forEach(function(errorAlert) {
                errorAlert.classList.remove('show');
                errorAlert.classList.add('fade');
                setTimeout(() => errorAlert.remove(), 600); // Remove after fade out
            });
        }, 3000); // Alerts will disappear after 3 seconds
    });
</script>
@endsection
