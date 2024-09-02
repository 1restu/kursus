@extends('layouts.app')
@section('content')
<style>
    .card {
        border-radius: 8px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
    }

    .table {
        margin-bottom: 0; /* Adjust the bottom margin of the table if needed */
    }

    .card-body {
        padding: 1.5rem; /* Adjust padding for better spacing */
    }

    .custom-margin-top {
        margin-top: 20px; /* Adjust the value as needed */
    }
</style>
<div class="container-fluid mt-n22 px-6">
    <div class="row">
        <div class="col-xl-3 col-lg-6 col-md-12 col-12 mt-6">
            <div class="card ">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h4 class="mb-0">Kategori</h4>
                        </div>
                        <div class="icon-shape icon-md bg-light-primary text-primary rounded-2">
                            <i class="fas fa-list fs-4"></i>
                        </div>
                    </div>
                    <div>
                        <h1 class="fw-bold">{{ $categoryCount }}</h1>
                        <p class="mb-0"><span class="text-dark me-2">{{ $categoryCount }}</span>Kategori kursus</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-12 col-12 mt-6">
            <div class="card ">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h4 class="mb-0">Materi</h4>
                        </div>
                        <div class="icon-shape icon-md bg-light-primary text-primary rounded-2">
                            <i class="fas fa-file-alt fs-4"></i>
                        </div>
                    </div>
                    <div>
                        <h1 class="fw-bold">{{ $materyCount }}</h1>
                        <p class="mb-0"><span class="text-dark me-2">{{ $materyCount }}</span>Materi Belajar</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-12 col-12 mt-6">
            <div class="card ">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h4 class="mb-0">Kursus</h4>
                        </div>
                        <div class="icon-shape icon-md bg-light-primary text-primary rounded-2">
                            <i class="fas fa-book fs-4"></i>
                        </div>
                    </div>
                    <div>
                        <h1 class="fw-bold">{{ $courseCount }}</h1>
                        <p class="mb-0"><span class="text-dark me-2">{{ $courseCount }}</span>Kurus Tersedia</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-12 col-12 mt-6">
            <div class="card ">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h4 class="mb-0">Pendapatan</h4>
                        </div>
                        <div class="icon-shape icon-md bg-light-primary text-primary rounded-2">
                            <i class="fas fa-hourglass-half fs-4"></i>
                        </div>
                    </div>
                    <div>
                        <h1 class="fw-bold">{{ $revenue }}</h1>
                        <p class="mb-0"><span class="text-success me-2">{{ $revenue }}</span>Didapatkan</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Row for Table and List -->
    <div class="row mt-6">
        <!-- Table Column (70% width) -->
        <div class="col-xl-8 col-lg-8 col-md-12 mb-6 custom-margin-top">
            <div class="card">
                <div class="card-header bg-white py-4">
                    <h4 class="mb-0">Pendaftar Terbaru</h4>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-bordered">
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
                            <!-- Additional rows as needed -->
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-white text-center">
                    <a href="/courses" class="link-primary">Lihat Semua</a>
                </div>
            </div>
        </div>

        <!-- List Items Column (30% width) -->
        <div class="col-xl-4 col-lg-4 col-md-12 custom-margin-top">
            <div class="card h-100">
                <div class="d-flex align-items-center justify-content-between">
                    <h4 class="mt-2 ml-2">{{ __('Pendaftar Terbaru') }}</h4>
                </div>
                <div class="card-body">
                    <ol class="list-group list-group-numbered">
                        @foreach ($courseList as $list)
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold">{{ $list->nama_krs }}</div>
                                {{ $list->deskripsi }}
                            </div>
                            <span class="badge bg-primary rounded-pill">{{ $list->pendaftar->count() }} Pendaftar</span>
                        </li>
                        @endforeach
                        <!-- Additional list items as needed -->
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection