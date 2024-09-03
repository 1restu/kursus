{{-- resources/views/pd_kursus/pd_kursus_table.blade.php --}}

<div class="col-lg-12 mt-3">
    <div class="table-responsive">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show my-2" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show my-2" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show my-2" role="alert">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
                    {{-- <div class="col-sm-4"></div>
                    <div class="col-sm-4 d-flex justify-content-sm-start">
                        <h2 class="card-title">Pendaftar</b></h2>
                        <div class="d-flex">
                            {{-- <div class="search-box me-2">
                                <i class="material-icons">&#xE8B6;</i>
                                <input type="text" class="form-control" placeholder="Search&hellip;">
                            </div> --}}
                            {{-- <a href="{{ route('regists.create', ['id_krs' => $course_id]) }}" class="btn btn-primary">Tambah Data Baru</a>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="d-flex justify-content-between">
                            <form action="#" method="GET" class="d-flex">
                                <input type="text" name="search" class="form-control" placeholder="Cari...">
                                <button type="submit" class="btn btn-secondary ms-2">Search</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div> --}}
            <h2 class="card-title mt-1 mb-1">Daftar Data</h2>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href="{{ route('regists.create', ['id_krs' => $course_id]) }}" class="btn btn-primary">Tambah Data Baru</a>
                {{-- <form action=""{{ route('courses.show', ['course' => $course->id]) }}"" method="GET" class="d-flex">
                    <input type="text" name="search" class="form-control" placeholder="Cari..." value="{{ request()->get('search') }}">
                    <button type="submit" class="btn btn-secondary ms-2">Search</button>
                </form> --}}
            </div>
            <table class="table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kursus</th>
                        <th>Nama Murid</th>
                        <th>Biaya</th>
                        <th>Status</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    
                    @foreach($regists as $regist)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $regist->kursus->nama_krs }}</td>
                            <td>{{ $regist->murid->nama }}</td>
                            <td>{{ 'Rp ' . number_format($regist->kursus->biaya_krs, 0, ',', '.') }}</td>
                            <td>{{ $regist->status }}</td>
                            <td>{{ \Carbon\Carbon::parse($regist->tanggal_mulai)->format('d-m-Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($regist->tanggal_selesai)->format('d-m-Y') }}</td>
                            <td>
                                @if ($regist->status !== 'lunas')
                                <a href="{{ route('regists.edit', $regist->id) }}" title="Edit" data-bs-toggle="modal" data-bs-target="#confirmPaymentModal"><i class="fas fa-dollar-sign" style="color: rgb(223, 223, 56);"></i></a>
                                @endif
                                <form action="{{ route('regists.destroy', $regist->id) }}" method="POST" style="display:inline;" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="border: none; background-color: transparent;">
                                        <i class="fas fa-trash" style="color: red;"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <div class="modal fade" id="confirmPaymentModal" tabindex="-1" aria-labelledby="confirmPaymentLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="confirmPaymentLabel">Konfirmasi Pembayaran</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('regist.payment', $regist->id) }}" method="POST">
                                            @csrf
                                            <p>Apakah Anda yakin ingin mengonfirmasi pembayaran ini?</p>
                                            <div class="mb-3">
                                                <label for="courseName" class="form-label">Kursus</label>
                                                <input type="text" class="form-control" id="courseName" readonly value="{{ $regist->kursus->nama_krs }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="studentName" class="form-label">Nama Murid</label>
                                                <input type="text" class="form-control" id="studentName" readonly value="{{$regist->murid->nama  }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="courseFee" class="form-label">Biaya</label>
                                                <input type="text" class="form-control" id="courseFee" readonly value="{{ 'Rp ' . number_format($regist->kursus->biaya_krs, 0, ',', '.') }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="startDate" class="form-label">Tanggal Mulai</label>
                                                <input type="text" class="form-control" id="startDate" readonly value="{{ \Carbon\Carbon::parse($regist->tanggal_mulai)->format('d-m-Y') }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="endDate" class="form-label">Tanggal Selesai</label>
                                                <input type="text" class="form-control" id="endDate" readonly value="{{ \Carbon\Carbon::parse($regist->tanggal_selesai)->format('d-m-Y') }}">
                                            </div>
                                            <button type="submit" class="btn btn-primary">Konfirmasi Pembayaran</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
            {{-- <div class="clearfix">
                <div class="hint-text">Menampilkan <b>
                    {{ $regists->count() }}
                </b> dari <b>
                    {{ $regists->total() }}
                </b> entri</div>
                <ul class="pagination">
                    {{ $regists->links() }}
                </ul>
            </div> --}}
        </div>
    </div>
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