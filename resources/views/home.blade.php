@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            {{-- <div class="card-header">{{ __('Dashboard') }}</div> --}}

            <div class="card-body text-start">
                {{-- @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif --}}
                <h3>{{ __('Selamat Datang') }}</h3>
                <p>{{ Auth::user()->name }}</p>
                {{-- <p>Email Anda: {{ Auth::user()->email }}</p> --}}
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card">
            <div class="card-body d-flex align-items-center">
                <i class="fas fa-hourglass-half fa-2x mr-3"></i>
                <div>
                    <h5 class="card-title">Kursus Aktif</h5>
                    <h3 class="card-text">{{ $activeCourses }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card">
            <div class="card-body d-flex align-items-center">
                <i class="fas fa-hourglass-half fa-2x mr-3"></i>
                <div>
                    <h5 class="card-title">Pendapatan</h5>
                    <h3 class="card-text">{{ $revenue }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-3">
        <div class="card">
            <div class="card-body d-flex align-items-center">
                <i class="fas fa-user fa-2x mr-3"></i>
                <div>
                    <h5 class="card-title">Siswa</h5>
                    <h3 class="card-text">{{ $studentCount }}</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body d-flex align-items-center">
                <i class="fas fa-list fa-2x mr-3"></i>
                <div>
                    <h5 class="card-title" style="margin-left: 2px">Kategori</h5>
                    <h3 class="card-text">{{ $categoryCount }}</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body d-flex align-items-center">
                <i class="fas fa-book fa-2x mr-3 pr3"></i>
                <div>
                    <h5 class="card-title">Kursus</h5>
                    <h3 class="card-text">{{ $courseCount }}</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body d-flex align-items-center">
                <i class="fas fa-file-alt fa-2x mr-3"></i>
                <div class="justify-contend-end">
                    <h5 class="card-title">Materi</h5>
                    <h3 class="card-text">{{ $materyCount }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="row mt-3">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Pendaftar Terbaru</div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Kursus</th>
                            <th>Nama Murid</th>
                            <th>Biaya</th>
                            <th>Status</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($regists as $regist)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $regist->kursus->nama_krs }}</td>
                                <td>{{ $regist->murid->nama }}</td>
                                <td>{{ \Carbon\Carbon::parse($regist->tanggal_mulai)->format('d-m-Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($regist->tanggal_selesai)->format('d-m-Y') }}</td>
                                <td>{{ 'Rp ' . number_format($regist->kursus->biaya_krs, 0, ',', '.') }}</td>
                                <td>{{ $regist->status }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Informasi Tambahan -->
    {{-- <div class="col-md-3">
        <div class="card">
            <div class="card-header">Informasi Tambahan</div>
            <div class="card-body">
                <h5 class="card-title">Stok Barang Menipis</h5>
                <ul class="list-group">
                    @foreach ($lowStockItems as $item)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $item->name }}
                            <span class="badge bg-danger rounded-pill">Stok: {{ $item->quantity }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div> --}}
</div>
</div>
@endsection
