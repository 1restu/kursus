<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MateriModel;

class MateriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $materi=MateriModel::latest('created_at')->get();
        return view('', compact('materi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
            'id_ktg' => 'required|exists'
        ], [
            'nama_mtr.required' => 'Nama materi wajib di isi.',
            'nama_mtr.unique' => 'Nama materi sudah ada, silahkan masukkan nama yang lain.',
            'nama_mtr.regex' => 'Nama materi hanya boleh terdiri dari huruf.',
            'deskripsi.required' => 'Dekripsi materi wajib di isi.',
            'deskripsi.min' => 'Dekripsi minimal memiliki 10 kata.',
            'file_mtr.required' => 'File materi wajib diunggah.',
            'file_mtr.max' => 'Ukuran file tidak boleh lebih dari 5MB.',
            'file_mtr.mimes' => 'Format file harus berupa PDF, DOC, DOCX, atau TXT.',
            'id_ktg.required' => 'Kategori tidak boleh kosong',
            'id_ktg.exists' => 'Kategori tidak valid.'
        ]);
    
        if ($request->hasFile('file_mtr')) {
            $file = $request->file('file_mtr');
            $fileName = time() . '_' . $file->getClientOriginalName();
    
            $filePath = public_path('asset/files/' . $fileName);
            if (file_exists($filePath)) {
                return redirect()->back()->with('error', 'File dengan nama yang sama sudah ada.');
            }
    
            $file->move(public_path('asset/files'), $fileName);
    
            try {
                MateriModel::create([
                    'nama_mtr' => $request->nama_mtr,
                    'deskripsi' => $request->deskripsi,
                    'file_mtr' => $fileName,
                    'id_ktg' => $request->id_ktg
                ]);
    
                return redirect()->route('materi.index')->with('success', 'Materi baru berhasil ditambahkan.');
            } catch (\Exception $e) {
                return redirect()->route('materi.create')->with('error', 'Gagal menambahkan materi baru.');
            }
    }
    
        }
    
        /**
         * Show the form for editing the specified resource.
         */
        public function edit(string $id)
        {
            //
        }
    
        /**
         * Update the specified resource in storage.
         */
        public function update(Request $request, string $id)
        {
            $request->validate([
                'nama_mtr' => 'required|unique:materi,nama_mtr|regex:/^[a-zA-Z\s]+$/',
                'deskripsi' => 'required|min:10',
                'file_mtr' => 'required|file|max:5120|mimes:pdf,doc,docx,txt',
                'id_ktg' => 'required|exists'
            ], [
                'nama_mtr.required' => 'Nama materi wajib di isi.',
                'nama_mtr.unique' => 'Nama materi sudah ada, silahkan masukkan nama yang lain.',
                'nama_mtr.regex' => 'Nama materi hanya boleh terdiri dari huruf.',
                'deskripsi.required' => 'Dekripsi materi wajib di isi.',
                'deskripsi.min' => 'Dekripsi minimal memiliki 10 kata.',
                'file_mtr.required' => 'File materi wajib diunggah.',
                'file_mtr.max' => 'Ukuran file tidak boleh lebih dari 5MB.',
                'file_mtr.mimes' => 'Format file harus berupa PDF, DOC, DOCX, atau TXT.',
                'id_ktg.required' => 'Kategori tidak boleh kosong',
                'id_ktg.exists' => 'Kategori tidak valid.'
            ]);
        
            if ($request->hasFile('file_mtr')) {
                $file = $request->file('file_mtr');
                $fileName = time() . '_' . $file->getClientOriginalName();
        
                $filePath = public_path('asset/files/' . $fileName);
                if (file_exists($filePath)) {
                    return redirect()->back()->with('error', 'File dengan nama yang sama sudah ada.');
                }
                if ($materi->file_mtr && file_exists(public_path('asset/files/' . $materi->file_mtr))) {
                    unlink(public_path('asset/files/' . $materi->file_mtr));
                }
        
                $file->move(public_path('asset/files'), $fileName);
        
                try {
                    MateriModel::update([
                        'nama_mtr' => $request->nama_mtr,
                        'deskripsi' => $request->deskripsi,
                        'file_mtr' => $fileName,
                        'id_ktg' => $request->id_ktg
                    ]);
        
                    return redirect()->route('materi.index')->with('success', 'Materi baru berhasil di edit.');
                } catch (\Exception $e) {
                    return redirect()->route('materi.create')->with('error', 'Gagal mengedit Materi.');
                }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    try {
        if ($materi->file_mtr && file_exists(public_path('asset/files/' . $materi->file_mtr))) {
            unlink(public_path('asset/files/' . $materi->file_mtr));
        }
        $materi->delete();

        return redirect()->route('materi.index')->with('success', 'Materi berhasil dihapus.');
    } catch (\Exception $e) {
        return redirect()->route('materi.index')->with('error', 'Gagal menghapus materi.');
    }
}
}
