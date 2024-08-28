<?php

namespace App\Http\Controllers;

use App\Models\KtgMateriModel;
use Illuminate\Http\Request;
Use App\Models\KursusModel;
use App\Models\MateriModel;

class KursusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = KursusModel::latest('created_at')->get();
        return view('courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = KtgMateriModel::latest('created_at')->get();
        $materies = MateriModel::latest('created_at')->get();
        return view('courses.create', compact('categories', 'materies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_krs' => 'required|unique:kursus,nama_krs|regex:/^[a-zA-Z\s]+$/',
            'gambar' => 'required|image|max:5280|mimes:jpeg,png,jpg',
            'deskripsi' => 'required|min:10',
            'id_mtr' => 'required|exists:materi,id',
            'biaya_krs' => 'required|numeric|min:0',
            'durasi' => 'required|integer|min:1'
        ], [
            'nama_krs.required' => 'Nama kursus wajib diisi.',
            'nama_krs.unique' => 'Nama kursus sudah ada, silahkan masukkan nama yang lain.',
            'nama_krs.regex' => 'Nama kursus hanya boleh terdiri dari huruf.',
            'gambar.required' => 'Mohon lampirkan gambar.',
            'gambar.image' => 'File harus berupa gambar.',
            'gambar.mimes' => 'Format gambar harus berupa jpeg, png, jpg, atau gif.',
            'gambar.max' => 'Ukuran gambar tidak boleh lebih dari 2MB.',
            'deskripsi.required' => 'Deskripsi kursus wajib diisi.',
            'deskripsi.min' => 'Deskripsi minimal memiliki 10 karakter.',
            'id_mtr.required' => 'Materi tidak boleh kosong.',
            'id_mtr.exists' => 'Materi tidak valid.',
            'biaya_krs.required' => 'Biaya kursus wajib diisi.',
            'biaya_krs.numeric' => 'Biaya kursus hanya boleh berupa angka.',
            'biaya_krs.min' => 'Biaya kursus tidak boleh kurang dari 0.',
            'durasi.required' => 'Durasi kursus wajib diisi.',
            'durasi.integer' => 'Durasi kursus harus berupa bilangan bulat.',
            'durasi.min' => 'Durasi kursus minimal adalah 1 bulan.'
        ]);

        if($request->hasFile('gambar')){
            $file = $request->file('gambar');
            $filename=time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('assets/images'), $filename);

            try {
                KursusModel::create([
                    'nama_krs' => $request->nama_krs,
                    'gambar' => $filename,
                    'deskripsi' => $request->deskripsi,
                    'id_mtr' => $request->id_mtr,
                    'biaya_krs' => $request->biaya_krs,
                    'durasi' => $request->durasi
                ]);

                return redirect('/courses')->with('succes', 'Kursus baru berhasil ditambahkan');
            } catch(\Exception $e) {
                return redirect('/courses')->with('error', "$e");
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id){
    $course = KursusModel::with('materi')->findOrFail($id);
    
    // Mengirim data ke view
    return view('courses.show', compact('course'));}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $course = KursusModel::findOrFail($id);
        $categories = KtgMateriModel::latest('created_at')->get();
        $materies = MateriModel::latest('created_at')->get();
        return view('courses.edit', compact('course','categories', 'materies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $kursus = KursusModel::find($id);
        $request->validate([
            'nama_krs' => 'required|unique:kursus,nama_krs,' . $id . '|regex:/^[a-zA-Z\s]+$/',
            'gambar' => 'required|image|max:5280|mimes:jpeg,png,jpg',
            'deskripsi' => 'required|unique:kursus,nama_krs|min:10',
            'id_mtr' => 'required|exists:materi,id',
            'biaya_krs' => 'required|numeric|min:0',
            'durasi' => 'required|integer|min:1'
        ], [
            'nama_krs.required' => 'Nama kursus wajib diisi.',
            'nama_krs.unique' => 'Nama kursus sudah ada, silahkan masukkan nama yang lain.',
            'nama_krs.regex' => 'Nama kursus hanya boleh terdiri dari huruf.',
            'gambar.required' => 'Mohon lampirkan gambar.',
            'gambar.image' => 'File harus berupa gambar.',
            'gambar.mimes' => 'Format gambar harus berupa jpeg, png, jpg, atau gif.',
            'gambar.max' => 'Ukuran gambar tidak boleh lebih dari 2MB.',
            'deskripsi.required' => 'Deskripsi kursus wajib diisi.',
            'deskripsi.min' => 'Deskripsi minimal memiliki 10 karakter.',
            'id_mtr.required' => 'Materi tidak boleh kosong.',
            'id_mtr.exists' => 'Materi tidak valid.',
            'biaya_krs.required' => 'Biaya kursus wajib diisi.',
            'biaya_krs.numeric' => 'Biaya kursus hanya boleh berupa angka.',
            'biaya_krs.min' => 'Biaya kursus tidak boleh kurang dari 0.',
            'durasi.required' => 'Durasi kursus wajib diisi.',
            'durasi.integer' => 'Durasi kursus harus berupa bilangan bulat.',
            'durasi.min' => 'Durasi kursus minimal adalah 1 bulan.'
        ]);

        if($request->hasFile('gambar')){
            $file = $request->file('gambar');
            $filename=time() . '_' . $file->getClientOriginalName();
            if ($kursus->gambar && file_exists(public_path('assets/images' . $kursus->gambar))) {
                unlink(public_path('assets/images/' . $kursus->gambar));
            }
            $file->move(public_path('assets/images'), $filename);
            $kursus->gambar = $filename;

            try {
                $kursus->update([
                    'nama_krs' => $request->nama_krs,
                    'gambar' => $kursus->gambar,
                    'deskripsi' => $request->deskripsi,
                    'id_mtr' => $request->id_mtr,
                    'biaya_krs' => $request->biaya_krs,
                    'durasi' => $request->durasi
                ]);

                return redirect('/courses')->with('succes', 'Kursus berhasil diedit');
            } catch(\Exception $e) {
                return redirect('/courses')->with('error', 'Kursus gagal diedit.');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    $kursus = KursusModel::find($id);

    try {
        if ($kursus->gambar && file_exists(public_path('assets/images' . $kursus->gambar))) {
            unlink(public_path('assets/images' . $kursus->gambar));
        }
        $kursus->delete();

        return redirect()->route('coursees.index')->with('success', 'Kursus berhasil dihapus.');
    } catch (\Exception $e) {
        if ($e->getCode() == 23000) {
            return redirect()->route('courses.index')->with('error', 'Kursus tidak dapat dihapus karena masih terkait dengan pendaftaran kursus.');
        }

        return redirect()->route('courses.index')->with('error', 'Gagal menghapus kursus.');
    }
}

}
