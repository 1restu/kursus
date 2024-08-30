<?php

namespace App\Http\Controllers;

use App\Models\KtgMateriModel;
use Illuminate\Http\Request;
use App\Models\MateriModel;

class MateriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = MateriModel::query();

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama_mtr', 'like', "%{$search}%")
                  ->orWhere('file_mtr', 'like', "%{$search}%");
            });

            $materies = $query->latest('created_at')->get();

            if ($materies->isEmpty()) {
                return redirect()->route('materies.index')
                                 ->with('error', 'Tidak ada hasil ditemukan untuk pencarian: ' . $search)
                                 ->withInput();
            }
        } else {
            $materies = MateriModel::with('kategori')->latest('created_at')->get();
        }
        return view('materies.index', compact('materies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = KtgMateriModel::latest('created_at')->get();
        return view('materies.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
        {
            $request->validate([
                'nama_mtr' => 'required|unique:materi,nama_mtr|regex:/^[a-zA-Z\s]+$/',
                'deskripsi' => 'required|min:10',
                'file_mtr' => 'required|file|max:5120|mimes:pdf,doc,docx,txt',
                'id_ktg' => 'required|exists:ktg_materi,id'
            ], [
                'nama_mtr.required' => 'Nama materi wajib di isi.',
                'nama_mtr.unique' => 'Nama materi sudah ada, silahkan masukkan nama yang lain.',
                'nama_mtr.regex' => 'Nama materi hanya boleh terdiri dari huruf.',
                'deskripsi.required' => 'Deskripsi materi wajib di isi.',
                'deskripsi.min' => 'Deskripsi minimal memiliki 10 kata.',
                'file_mtr.required' => 'File materi wajib diunggah.',
                'file_mtr.max' => 'Ukuran file tidak boleh lebih dari 5MB.',
                'file_mtr.mimes' => 'Format file harus berupa PDF, DOC, DOCX, atau TXT.',
                'id_ktg.required' => 'Kategori tidak boleh kosong.',
                'id_ktg.exists' => 'Kategori tidak valid.'
            ]);

            if ($request->hasFile('file_mtr')) {
                $file = $request->file('file_mtr');
                $fileName = time() . '_' . $file->getClientOriginalName();

                $filePath = public_path('assets/files/' . $fileName);
                if (file_exists($filePath)) {
                    return redirect()->back()->with('error', 'File dengan nama yang sama sudah ada.');
                }

                $file->move(public_path('assets/files'), $fileName);

                try {
                    MateriModel::create([
                        'nama_mtr' => $request->nama_mtr,
                        'deskripsi' => $request->deskripsi,
                        'file_mtr' => $fileName,
                        'id_ktg' => $request->id_ktg
                    ]);

                    return redirect()->route('materies.index')->with('success', 'Materi baru berhasil ditambahkan.');
                } catch (\Exception $e) {
                    return redirect()->route('materies.create')->with('error', 'Gagal menambahkan materi baru.');
                }
            }
        }
    
        /**
         * Show the form for editing the specified resource.
         */
        public function edit(string $id)
        {
            $materi=MateriModel::findOrFail($id);
            $categories = KtgMateriModel::latest('created_at')->get();
            return view('materies.edit', compact('materi', 'categories'));
        }
    
        /**
         * Update the specified resource in storage.
         */
        public function update(Request $request, string $id)
            {
                $materi = MateriModel::findOrFail($id);
                if ($materi->Kursus()->exists()) {
                    return redirect()->back()->with('error', 'Materi tidak dapat diubah karena masih terkait dengan kursus.');
                }

        // Validasi
        $request->validate([
            'nama_mtr' => 'required|unique:materi,nama_mtr,' . $id . '|regex:/^[a-zA-Z\s]+$/',
            'deskripsi' => 'required|min:10',
            'file_mtr' => 'nullable|file|max:5120|mimes:pdf,doc,docx,txt',
            'id_ktg' => 'required|exists:ktg_materi,id' // Tambahkan nama tabel dan kolom untuk validasi
        ], [
            'nama_mtr.required' => 'Nama materi wajib di isi.',
            'nama_mtr.unique' => 'Nama materi sudah ada, silahkan masukkan nama yang lain.',
            'nama_mtr.regex' => 'Nama materi hanya boleh terdiri dari huruf.',
            'deskripsi.required' => 'Deskripsi materi wajib di isi.',
            'deskripsi.min' => 'Deskripsi minimal memiliki 10 karakter.',
            'file_mtr.nullable' => 'File materi tidak wajib diunggah.',
            'file_mtr.max' => 'Ukuran file tidak boleh lebih dari 5MB.',
            'file_mtr.mimes' => 'Format file harus berupa PDF, DOC, DOCX, atau TXT.',
            'id_ktg.required' => 'Kategori tidak boleh kosong',
            'id_ktg.exists' => 'Kategori tidak valid.'
        ]);

        // Jika ada file yang diunggah
        if ($request->hasFile('file_mtr')) {
            $file = $request->file('file_mtr');
            $fileName = time() . '_' . $file->getClientOriginalName();

            $filePath = public_path('assets/files/' . $fileName);
            if (file_exists($filePath)) {
                return redirect()->back()->with('error', 'File dengan nama yang sama sudah ada.');
            }

            // Hapus file lama jika ada
            if ($materi->file_mtr && file_exists(public_path('assets/files/' . $materi->file_mtr))) {
                unlink(public_path('assets/files/' . $materi->file_mtr));
            }

            // Pindahkan file baru
            $file->move(public_path('assets/files'), $fileName);

            // Update data
            $materi->update([
                'nama_mtr' => $request->nama_mtr,
                'deskripsi' => $request->deskripsi,
                'file_mtr' => $fileName,
                'id_ktg' => $request->id_ktg
            ]);

            return redirect()->route('materies.index')->with('success', 'Materi berhasil diupdate.');
        } else {
            // Jika tidak ada file baru yang diunggah
            $materi->update([
                'nama_mtr' => $request->nama_mtr,
                'deskripsi' => $request->deskripsi,
                'id_ktg' => $request->id_ktg
            ]);

            return redirect()->route('materies.index')->with('success', 'Materi berhasil diupdate.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $materies = MateriModel::with('kategori')->findOrFail($id); // Ambil data materi dan relasinya
        return view('materies.show', compact('materies')); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    $materi = MateriModel::find($id);
    if ($materi->Kursus()->exists()) {
        return redirect()->route('materies.index')->with('error', 'Materi tidak dapat dihapus karena masih terkait dengan kursus.');
    }
    try {
        if ($materi->file_mtr && file_exists(public_path('assets/files/' . $materi->file_mtr))) {
            unlink(public_path('assets/files/' . $materi->file_mtr));
        }
        $materi->delete();

        return redirect()->route('materies.index')->with('success', 'Materi berhasil dihapus.');
    } catch (\Exception $e) {
        return redirect()->route('materies.index')->with('error', 'Gagal menghapus materi.');
    }
}
}
