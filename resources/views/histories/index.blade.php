@extends('layouts.app')

@section('title', 'Riwayat')
@section('content')
    
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
<style>
    body {
    margin-top: 20px;
    background: #ffffff;
}

.card {
    box-shadow: 0 20px 27px 0 rgb(0 0 0 / 5%);
}

.avatar.sm {
    width: 2.25rem;
    height: 2.25rem;
    font-size: .818125rem;
}

.table-nowrap .table td,
.table-nowrap .table th {
    white-space: nowrap;
}

.table>:not(caption)>*>* {
    padding: 0.75rem 1.25rem;
    border-bottom-width: 1px;
}

table th {
    font-weight: 600;
    background-color: #eeecfd !important;
}

.fa-arrow-up {
    color: #00CED1;
}

.fa-arrow-down {
    color: #FF00FF;
}
</style>
<div class="container">
    <div class="row">
        <div class="col-12 mb-3 mb-lg-5">
            <div class="position-relative card table-nowrap table-card">
                <div class="card-header align-items-center">
                    <h5 class="mb-0">History</h5>
                    <p class="mb-0 small text-muted">{{ count($histories) }} Data</p>
                </div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="small text-uppercase bg-body text-muted">
                            <tr>
                                <th>No</th>
                                <th>Kursus</th>
                                <th>Nama Murid</th>
                                <th>Mulai</th>
                                <th>Selesai</th>
                                {{-- <th>Status</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($histories as $history)
                            <tr class="align-middle">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $history->nama_kursus }}</td>
                                <td>{{ $history->nama_murid }}</td>
                                <td>{{ $history->tanggal_mulai }}</td>
                                <td>{{ $history->tanggal_selesai }}</td>
                                {{-- <td>
                                    <span class="badge fs-6 fw-normal {{ $history->status == 'Lunas' ? 'bg-tint-success text-success' : 'bg-tint-warning text-warning' }}">
                                        {{ $history->status }}
                                    </span>
                                </td> --}}
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- <div class="card-footer text-end">
                    <a href="#!" class="btn btn-gray">View All Transactions</a>
                </div> --}}
            </div>
        </div>
    </div>
</div>

@endsection
