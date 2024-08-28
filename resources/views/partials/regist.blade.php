{{-- resources/views/pd_kursus/pd_kursus_table.blade.php --}}
<div class="col-lg-12 mt-3">
    <div class="table-responsive">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-8"><h2>Detail <b>Kursus</b></h2></div>
                    <div class="col-sm-4">
                        <div class="d-flex justify-content-end">
                            <div class="search-box me-2">
                                <i class="material-icons">&#xE8B6;</i>
                                <input type="text" class="form-control" placeholder="Search&hellip;">
                            </div>
                            <a href="{{ route('pd_kursus.create') }}" class="btn btn-primary">Tambah Data Baru</a>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Murid</th>
                        <th>Status</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pd_kursus as $key => $kursus)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $kursus->murid->nama }}</td>
                            <td>{{ $kursus->status }}</td>
                            <td>{{ \Carbon\Carbon::parse($kursus->tanggal_mulai)->format('d-m-Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($kursus->tanggal_selesai)->format('d-m-Y') }}</td>
                            <td>
                                <a href="{{ route('pd_kursus.show', $kursus->id) }}" class="view" title="View" data-toggle="tooltip"><i class="material-icons">&#xE417;</i></a>
                                <a href="{{ route('pd_kursus.edit', $kursus->id) }}" class="edit" title="Edit" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
                                <form action="{{ route('pd_kursus.destroy', $kursus->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete" title="Delete" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="clearfix">
                <div class="hint-text">Menampilkan <b>{{ $pd_kursus->count() }}</b> dari <b>{{ $pd_kursus->total() }}</b> entri</div>
                <ul class="pagination">
                    {{ $pd_kursus->links() }}
                </ul>
            </div>
        </div>
    </div>
</div>
