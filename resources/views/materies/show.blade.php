<!-- Modal untuk Detail Materi -->

{{-- @extends('layouts.app')

@section('content')
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Detail Materi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <!-- Input untuk Nama -->
                    <div class="mb-3">
                        <label for="modalNama" class="form-label">Nama</label>
                        <input type="text" id="modalNama" class="form-control" readonly value="{{ $materies->nama_mtr }}">
                    </div>
                    
                    <!-- Input untuk Size -->
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="dekripsi" rows="4" readonly>{{ $materies->deskripsi }}</textarea>
                    </div>
                    
                    <!-- Input untuk Date -->
                    <div class="mb-3">
                        <label for="kategori" class="form-label">Kategori</label>
                        <input type="text" id="kategori" class="form-control" readonly value="{{ $materies->kategori->nama_ktg }}">
                    </div>
                    
                    <!-- Input untuk File -->
                    <div class="mb-3">
                        <label for="modalFile" class="form-label">File</label>
                        <input type="text" id="modalFile" class="form-control" readonly value="{{ $materies->file_mtr }}">
                    </div>
                    
                    <!-- Tombol Download -->
                    <div class="mb-3">
                        <a id="modalDownload" class="btn btn-primary" href="/assets/files/{{ $materies->file_mtr }}" target="_blank">Download File</a>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection --}}