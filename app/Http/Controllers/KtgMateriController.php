<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\KtgMateriModel;
use App\Models\MateriModel;

class KtgMateriController extends Controller
{
    public function ktgtampil()
    {
        $dataktg = KtgMateriModel::latest('created_at')->get();
        return view('halaman/kategori', ['kategori' => $dataktg]);
    }

    public function ktgtambah(Request $request)
    {
        $request->validate([
            'nama_ktg' => 'required|unique:ktg_materi,nama_ktg|regex:/^[a-zA-Z\s]+$/'
        ], [
            'nama_ktg.required' => 'Nama kategori tidak boleh kosong.',
            'nama_ktg.unique' => 'Kategori ini sudah ada, silahkan masukkan nama kategori yang lain.',
            'nama_ktg.regex' => 'Nama kategori hanya boleh terdiri dari huruf.'
        ]);

        try {
            KtgMateriModel::create([
                'nama_ktg' => $request->nama_ktg
            ]);

            return redirect('/kategori')->with('success', 'Kategori baru berhasil ditambahkan.');
        } catch(\Exception $e) {
            return redirect('/kategori')->with('error', 'Kategori baru gagal untuk ditambahkan');
        }
    }

    public function ktgedit($id, Request $request)
    {
        $ktg = KtgMateriModel::where('id', $id)->first();

        if (!$ktg) {
            return redirect('/kategori')->with('error', 'Kategori materi tak ditemukan.');
        }

        $kategoriterkait = MateriModel::where('id_ktg', $id)->exists();

        if ($kategoriterkait) {
            return redirect('/kategori')->with('error', 'Kategori tak dapat diedit karena masih terkait dengan materi.');
        }

        $request->validate([
            'nama_ktg' => [
                'required',
                Rule::unique('ktg_materi', 'nama_ktg')->ignore($ktg)
            ]
            ], [
                'nama_ktg.required' => 'Nama kategori wajib diisi.',
                'nama_ktg.unique' => 'Kategori ini sudah ada, silahkan ganti.'
            ]);

        try {
            $ktg->update([
                'nama_ktg' => $request->nama_ktg
            ]);

            return redirect('/kategori')->with('success', 'Kategori berhasil diedit.');
        } catch(\Exception $e) {
            return redirect('/kategori')->with('error', 'Kategori gagal diedit.');
        }
    }

    public function ktghapus($id)
    {
        $ktg = KtgMateriModel::find($id);

        if (!$ktg) {
            return redirect('/kategori')->with('error', 'Kategori tidak ditemukan.');
        }

        $kategoriterkait = MateriModel::where('id_ktg', $id)->exists();

        if ($kategoriterkait) {
            return redirect('/kategori')->with('error', 'Kategori tidak dapat dihapus karena masih terkait dengan materi.');
        }

        try {
            $ktg->delete();
            return redirect('/kategori')->with('success', 'Kategori berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect('/kategori')->with('error', 'Kategori gagal dihapus.');
        }
    }
}