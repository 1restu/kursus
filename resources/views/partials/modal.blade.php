<!-- resources/views/partials/modal.blade.php -->
<div class="modal fade" id="detailModal{{ $matery->id }}" tabindex="-1" aria-labelledby="detailModalLabel{{ $matery->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel{{ $matery->id }}">Detail Materi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    @csrf
                    <div class="mb-3">
                        <label for="modalNama" class="form-label">Nama</label>
                        <input type="text" id="modalNama" class="form-control" readonly value="{{ $matery->nama_mtr }}">
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="dekripsi" rows="4" readonly>{{ $matery->deskripsi }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="kategori" class="form-label">Kategori</label>
                        <input type="text" id="kategori" class="form-control" readonly value="{{ $matery->kategori->nama_ktg }}">
                    </div>
                    <div class="mb-3">
                        <label for="modalFile" class="form-label">File</label>
                        <input type="text" id="modalFile" class="form-control" readonly value="{{ $matery->file_mtr }}">
                    </div>
                    <div class="mb-3">
                        <a id="modalDownload" class="btn btn-primary" href="/assets/files/{{ $matery->file_mtr }}" target="_blank">Download File</a>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
