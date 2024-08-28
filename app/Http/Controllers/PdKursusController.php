<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PdKursusModel;
use App\Models\KursusModel;

class PdKursusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pdkursus = PdKursusModel::latest('tanggal_daftar')->get();
        return view('partials.regist', compact('pdkursus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('registrations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_krs' => 'required|exists:kursus,id',
            'id_mrd' => 'required|exists:murid,id',
            'tanggal_mulai' => 'required|date|after_or_equal:today'
        ], [
            'id_krs.required' => 'Kursus wajib dipilih.',
            'id_mrd.required' => 'Murid wajib dipilih.',
            'tanggal_mulai.required' => 'Tanggal mulai wajib diisi.',
            'tanggal_mulai.after_or_equal' => 'Tanggal mulai tidak boleh sebelum hari ini.'
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

            return redirect()->route('pd_kursus.index')->with('success', 'Pendaftaran berhasil dibuat.');
        } catch (\Exception $e) {
            return redirect()->route('pd_kursus.create')->with('error', 'Gagal membuat pendaftaran.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
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
            return redirect()->route('pd_kursus.index')->with('error', 'Pembayaran sudah dikonfirmasi.');
        }

        try {
            $pdkursus->update([
                'status' => 'lunas'
            ]);

            return redirect()->route('pd_kursus.index')->with('success', 'Pembayaran berhasil dikonfirmasi.');
        } catch (\Exception $e) {
            return redirect()->route('pd_kursus.index')->with('error', 'Gagal mengonfirmasi pembayaran.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $pdkursus = PdKursusModel::findOrFail($id);

        if ($pdkursus->status == 'lunas') {
            History::create([
                'id_krs' => $pdkursus->id_krs,
                'id_mrd' => $pdkursus->id_mrd,
                'tanggal_mulai' => $pdkursus->tanggal_mulai,
                'tanggal_selesai' => $pdkursus->tanggal_selesai,
                'status' => 'selesai',
            ]);

            // Now delete the PdKursusModel
            $pdkursus->delete();

            return redirect()->route('pd_kursus.index')->with('success', 'Pendaftaran berhasil dipindahkan ke history dan dihapus.');
        } else {
            return redirect()->route('pd_kursus.index')->with('error', 'Pendaftaran tidak bisa dihapus karena status belum lunas.');
        }
    }
}
