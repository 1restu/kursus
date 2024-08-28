@extends('layouts.app')

@section('title', 'Daftar Murid')

@section('content')
<h3>Halaman Murid</h3>

<!-- Alert messages -->
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

<!-- Modal Tambah Murid -->

<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th scope="col">No</th>
                <th scope="col">Kursus</th>
                <th scope="col">No Telepon</th>
                <th scope="col">Alamat</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($histories as $history)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $history->kursus }}</td>
                    <td>{{ $history->no_tlp }}</td>
                    <td>{{ $history->alamat }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
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
