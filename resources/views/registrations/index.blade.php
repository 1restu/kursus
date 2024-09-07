@extends('layouts.app')

@section('title', 'Daftar Barang Keluar')

@section('content')

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
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="table-responsive">
    <a href="{{ route('exports.create') }}" class="btn btn-primary mb-3">Pendaftaran</a>
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
            <th scope="col">No</th>
            <th scope="col">Kursus</th>
            <th scope="col">Murid</th>
            <th scope="col">Status</th>
            <th scope="col">Tanggal Mulai</th>
            <th scope="col">Tanggal Selesai</th>
            <th scope="col" class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($regists as $regist)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $regist->courses->nama_krs ?? 'N/A' }}</td>
                    <td>{{ $regist->students->nama ?? 'N/A' }}</td>
                    <td>{{ $regist->student }}</td>
                    <td>{{ $regist->tanggal_mulai->format('d-m-Y') }}</td>
                    <td>{{ $regist->tanggal_selesai->format('d-m-Y') }}</td>
                    <td class="text-center">
                        <a href="{{ route('exports.edit', $regist->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('exports.destroy', $regist->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Apakah Anda yakin ingin menghapusnya?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7"><center class="bg-danger text-white">Data tidak ada</center></td>
                </tr>
            @endforelse
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
                setTimeout(() => alertElement.remove(), 600); // Remove after fade out
            }
        }, 5000); // Alert will disappear after 3 seconds
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