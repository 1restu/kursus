<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PdKursusModel;
use App\Models\KursusModel;
use App\Models\HistoryModel;
use App\Models\MuridModel;

class PdKursusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $search = $request->input('search');
    $query = PdKursusModel::query();

    if ($search) {
        $query->whereHas('murid', function($q) use ($search) {
            $q->where('nama', 'like', "%{$search}%");
        })->orWhereHas('kursus', function($q) use ($search) {
            $q->where('nama_krs', 'like', "%{$search}%");
        });

        $pdkursus = $query->latest('created_at')->get();

        if ($pdkursus->isEmpty()) {
            return redirect()->route('pd_kursus.index')
                             ->with('error', 'Tidak ada hasil ditemukan untuk pencarian: ' . $search)
                             ->withInput();
        }
    } else {
        $pdkursus = PdKursusModel::latest('tanggal_daftar')->get();
    }

    return view('pd_kursus.index', compact('pdkursus'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $id_krs = $request->query('id_krs');
        $students = MuridModel::latest('created_at')->get();
        return view('registrations.create', compact('id_krs', 'students'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'id_krs' => 'required|exists:kursus,id',
        'id_mrd' => 'required|exists:murid,id',
        'tanggal_mulai' => 'required|date'
    ], [
        'id_krs.required' => 'Kursus wajib dipilih.',
        'id_mrd.required' => 'Murid wajib dipilih.',
        'tanggal_mulai.required' => 'Tanggal mulai wajib diisi.',
    ]);

    $kursus = KursusModel::find($request->id_krs);
    $tanggal_mulai = \Carbon\Carbon::parse($request->tanggal_mulai);
    $tanggal_selesai = $tanggal_mulai->copy()->addDays($kursus->durasi);

    try {
        PdKursusModel::create([
            'id_krs' => $kursus->id,
            'id_mrd' => $request->id_mrd,
            'biaya' => $kursus->biaya_krs,
            'status' => 'proses-pembayaran',
            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_selesai' => $tanggal_selesai
        ]);

        return redirect()->route('courses.show', ['course' => $kursus->id])->with('success', 'Pendaftaran berhasil dibuat.');
    } catch (\Exception $e) {
        return redirect()->route('regists.create', ['course' => $kursus->id])->with('error', 'Gagal menambah pendaftaran');
    }
}


    /**
     * Show the form for editing the specified resource.
     */
    public function show($id)
    {
        $regists = PdKursusModel::with('kursus', 'murid')->findOrFail($id);
    
    // Mengirim data ke view
        return view('partials.regist', compact('regists'));
    }
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $pdkursus = PdKursusModel::findOrFail($id);

        if ($pdkursus->status == 'lunas') {
            return redirect()->route('pd_kursus.index')->with('error', 'Pendaftaran tidak bisa di edit setelah status lunas.');
        }

        $request->validate([
            'id_krs' => 'required|exists:kursus,id',
            'id_mrd' => 'required|exists:murid,id',
            'tanggal_mulai' => 'required|date|after_or_equal:today'
        ]);

        $kursus = KursusModel::find($request->id_krs);
        $tanggal_mulai = \Carbon\Carbon::parse($request->tanggal_mulai);
        $tanggal_selesai = $tanggal_mulai->copy()->addDays($kursus->durasi);

        try {
            $pdkursus->update([
                'id_krs' => $kursus->id,
                'id_mrd' => $request->id_mrd,
                'biaya' => $kursus->biaya_krs,
                'tanggal_mulai' => $tanggal_mulai,
                'tanggal_selesai' => $tanggal_selesai
            ]);

            return redirect()->route('pd_kursus.index')->with('success', 'Pendaftaran berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->route('pd_kursus.edit', $id)->with('error', 'Gagal memperbarui pendaftaran.');
        }
    }

    /**
     * Confirm the payment of the specified resource.
     */
    public function confirmPayment($id)
    {
        $pdkursus = PdKursusModel::findOrFail($id);

        if ($pdkursus->status == 'lunas') {
            return redirect()->route('courses.show', $pdkursus->id_krs)->with('error', 'Pembayaran sudah dikonfirmasi.');
        }

        try {
            $pdkursus->update([
                'status' => 'lunas'
            ]);

            return redirect()->route('courses.show', $pdkursus->id_krs)->with('success', 'Pembayaran berhasil dikonfirmasi.');
        } catch (\Exception $e) {
            return redirect()->route('courses.show', $pdkursus->id_krs)->with('error', 'Gagal mengonfirmasi pembayaran.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    try {
        $pdkursus = PdKursusModel::findOrFail($id);

        if ($pdkursus->status == 'lunas') {
            // Jika status 'lunas', salin ke HistoryModel terlebih dahulu
            HistoryModel::create([
                'id_krs' => $pdkursus->id_krs,
                'id_mrd' => $pdkursus->id_mrd,
                'tanggal_mulai' => $pdkursus->tanggal_mulai,
                'tanggal_selesai' => $pdkursus->tanggal_selesai,
                'status' => 'selesai',
            ]);
        }

        // Hapus data dari PdKursusModel
        $pdkursus->delete();

        return redirect()->route('courses.show', $pdkursus->id_krs)
                        ->with('success', 'Pendaftaran berhasil dihapus.');

    } catch (\Exception $e) {
        // Tangani exception dan arahkan dengan pesan error
        return redirect()->route('courses.show', $id)
                        ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}



}
