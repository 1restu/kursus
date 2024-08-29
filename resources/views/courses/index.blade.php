@extends('layouts.app')

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
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
<h4 class="text-center font-weight-bold m-4">KURSUS</h4>
<div class="d-flex justify-content-end mb-3">
    <a href="{{ route('courses.create') }}" class="btn btn-primary mb-3">Tambah Kursus</a>
</div>
<div class="row mx-auto">
    {{-- @php
    $jumlah = count($cours);
    @endphp --}}
    @foreach($courses as $cours)
    <div class="card mr-2 mx-2 mb-4" style="width: 16rem;">
        <img src="{{ asset('assets/images/' . $cours->gambar) }}" class="card-img-top" alt="...">
        <div class="card-body bg-light mb-2">
            <h5 class="card-title">{{ $cours->nama_krs }}</h5>
            <p class="card-text">{{ 'Rp ' . number_format($cours->biaya_krs, 0, ',', '.') }}</p>
            {{-- <p class="card-text">{{  }}</p> --}}
            {{-- @if($cours->stok_produk != 0) --}}
                <a href="{{ route('courses.show', $cours->id) }}" class="btn btn-info">Detail</a>
            {{-- @if($cours->stok_produk != 0)
                <a href="{{ route('courses.show', ['id' => $cours->id]) }}" class="btn btn-info">Detail</a>
            @else
                <strong class="badge badge-warning text-weight-bold">PENUH</strong>
            @endif --}}
        </div>
    </div>
    @endforeach
</div>
@endsection


