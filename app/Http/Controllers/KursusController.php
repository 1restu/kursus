<?php

namespace App\Http\Controllers;

use App\Models\KtgMateriModel;
use Illuminate\Http\Request;
Use App\Models\KursusModel;
use App\Models\MateriModel;
use App\Models\PdKursusModel;

class KursusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = KursusModel::query();

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama_krs', 'like', "%{$search}%");
            });

            $courses = $query->latest('created_at')->get();

            if ($courses->isEmpty()) {
                return redirect()->route('courses.index')
                                 ->with('error', 'Tidak ada hasil ditemukan untuk pencarian: ' . $search)
                                 ->withInput();
            }
        } else {
            $courses = KursusModel::latest('created_at')->get();
        }
        return view('courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = KtgMateriModel::latest('created_at')->get();

        // Mendapatkan materi yang belum memiliki kursus (kursus_id null)
        $materies = MateriModel::whereNull('kursus_id')->latest('created_at')->get();

        $message = '';
        if ($materies->isEmpty()) {
            $message = 'Tidak ada materi yang tersedia untuk ditambahkan.';
        }

        return view('courses.create', compact('categories', 'materies', 'message'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_krs' => 'required|unique:kursus,nama_krs|regex:/^[a-zA-Z\s]+$/|min:5|max:20',
            'gambar' => 'required|image|max:5280|mimes:jpeg,png,jpg',
            'deskripsi' => 'required|min:10|max:100',
            'id_mtr' => 'required|array|max:3|exists:materi,id|min:1',
            'biaya_krs' => 'required|numeric|min:0|max:5000000',
            'durasi' => 'required|integer|min:1|max:365',
            'jam' => 'required|integer|min:1|max:6'
        ], [
            'nama_krs.required' => 'Nama kursus wajib diisi.',
            'nama_krs.unique' => 'Nama kursus sudah ada, silahkan masukkan nama yang lain.',
            'nama_krs.regex' => 'Nama kursus hanya boleh terdiri dari huruf.',
            'nama_krs.min'=>'Nama tidak boleh kurang dari 5',
            'nama_krs.max'=>'Nama tidak boleh lebih dari 20',
            'gambar.required' => 'Mohon lampirkan gambar.',
            'gambar.image' => 'File harus berupa gambar.',
            'gambar.mimes' => 'Format gambar harus berupa jpeg, png, jpg, atau gif.',
            'gambar.max' => 'Ukuran gambar tidak boleh lebih dari 2MB.',
            'deskripsi.required' => 'Deskripsi kursus wajib diisi.',
            'deskripsi.min' => 'Deskripsi minimal memiliki 10 karakter.',
            'deskripsi.max' => 'Deskripsi maksimal 100 karakter.',
            'id_mtr.max' => 'Kursus hanya bisa memiliki maksimal 3 materi.',
            'id_mtr.min' => 'Minimal kursus mempunyai 1 materi.',
            'id_mtr.required' => 'Pilih minimal satu materi untuk kursus ini.',
            'id_mtr.exists' => 'Materi tidak valid.',
            'biaya_krs.required' => 'Biaya kursus wajib diisi.',
            'biaya_krs.numeric' => 'Biaya kursus hanya boleh berupa angka.',
            'biaya_krs.min' => 'Biaya kursus tidak boleh kurang dari 0.',
            'biaya_krs.max' => 'Biaya kursus tidak boleh lebih dari 5 juta.',
            'durasi.required' => 'Durasi kursus wajib diisi.',
            'durasi.integer' => 'Durasi kursus harus berupa bilangan bulat.',
            'durasi.min' => 'Durasi kursus tidak boleh dibawah 0.',
            'durasi.max' => 'Durasi kursus tidak boleh lebih dari 1 tahun.',
            'jam.required' => 'Durasi jam perhari wajib diisi.',
            'jam.integer' => 'Durasi jam perhari harus berupa bilangan bulat.',
            'jam.min' => 'Durasi jam perhari tidak boleh dibawah 0.',
            'jam.max' => 'Durasi jam perhari tak boleh lebih dari 6 jam'
        ]);

        if($request->hasFile('gambar')){
            $file = $request->file('gambar');
            $filename= $file->getClientOriginalName();
            $uniqName = time() . '_' . uniqid() . '_' . $filename;

            if (KursusModel::where('original_gambar', $filename)->exists()) {
                return redirect()->back()->with('error', 'Gambar ini telah digunakan oleh kursus lain silahkan upload gambar yang berbeda.')->withInput();
            }
            $file->move(public_path('assets/images'), $uniqName);

            try {
                $kursus = KursusModel::create([
                    'nama_krs' => $request->nama_krs,
                    'gambar' => $uniqName,
                    'original_gambar' => $filename,
                    'deskripsi' => $request->deskripsi,
                    'biaya_krs' => $request->biaya_krs,
                    'durasi' => $request->durasi,
                    'jam' => $request->jam
                ]);

                MateriModel::whereIn('id', $request->id_mtr)->update(['kursus_id' => $kursus->id]);

                return redirect('/courses')->with('success', 'Kursus baru berhasil ditambahkan');
            } catch(\Exception $e) {
                return redirect('/courses')->with('error', 'Kursus baru gagal untuk di tambahkan. Error: ' . $e->getMessage());
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, Request $request){
    $course = KursusModel::with('materi')->findOrFail($id);

    $search = $request->input('search');
    $query = PdKursusModel::where('id_krs', $id)->with('murid');

    if ($search) {
        $query->whereHas('murid', function($q) use ($search) {
            $q->where('nama', 'like', "%{$search}%");
        });

        $regists = $query->latest('created_at')->get();

        if ($regists->isEmpty()) {
            return back()
                             ->with('error', 'Tidak ada hasil ditemukan untuk pencarian: ' . $search)
                             ->withInput();
        }
    } else {
        $regists = PdKursusModel::latest('tanggal_mulai')->get();
    }
    $regists = PdKursusModel::where('id_krs', $id)->with('kursus', 'murid')->get();
    
    // Mengirim data ke view
    return view('courses.show', compact('course', 'regists'));}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $course = KursusModel::findOrFail($id);
        $categories = KtgMateriModel::latest('created_at')->get();
        $materiSelectedIds = $course->materi->pluck('id')->toArray();

        // Mendapatkan materi yang belum terhubung dengan kursus lain atau yang sudah terhubung dengan kursus ini
        $materies = MateriModel::whereNull('kursus_id')
                                ->orWhereIn('id', $materiSelectedIds)
                                ->latest('created_at')
                                ->get();

        return view('courses.edit', compact('course', 'categories', 'materies', 'materiSelectedIds'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $kursus = KursusModel::find($id);

        $request->validate([
            'nama_krs' => 'required|unique:kursus,nama_krs,' . $id . '|regex:/^[a-zA-Z\s]+$/',
            'gambar' => 'nullable|image|max:5280|mimes:jpeg,png,jpg',
            'deskripsi' => 'required|min:10',
            'id_mtr' => 'required|array|max:3|exists:materi,id',
            'biaya_krs' => 'required|numeric|min:0',
            'durasi' => 'required|integer|min:1',
            'jam' => 'required|integer|min:1'
        ], [
            'nama_krs.required' => 'Nama kursus wajib diisi.',
            'nama_krs.unique' => 'Nama kursus sudah ada, silahkan masukkan nama yang lain.',
            'nama_krs.regex' => 'Nama kursus hanya boleh terdiri dari huruf.',
            'nama_krs.min'=>'Nama tidak boleh kurang dari 5',
            'nama_krs.max'=>'Nama tidak boleh lebih dari 20',
            'gambar.image' => 'File harus berupa gambar.',
            'gambar.mimes' => 'Format gambar harus berupa jpeg, png, jpg.',
            'gambar.max' => 'Ukuran gambar tidak boleh lebih dari 5MB.',
            'deskripsi.required' => 'Deskripsi kursus wajib diisi.',
            'deskripsi.min' => 'Deskripsi minimal memiliki 10 karakter.',
            'deskripsi.max' => 'Deskripsi maksimal 100 karakter.',
            'id_mtr.max' => 'Kursus hanya bisa memiliki maksimal 3 materi.',
            'id_mtr.required' => 'Pilih minimal satu materi untuk kursus ini.',
            'id_mtr.exists' => 'Materi tidak valid.',
            'id_mtr.min' => 'Minimal kursus mempunyai 1 materi.',
            'biaya_krs.required' => 'Biaya kursus wajib diisi.',
            'biaya_krs.numeric' => 'Biaya kursus hanya boleh berupa angka.',
            'biaya_krs.min' => 'Biaya kursus tidak boleh kurang dari 0.',
            'biaya_krs.max' => 'Biaya kursus tidak boleh lebih dari 5 juta.',
            'durasi.required' => 'Durasi kursus wajib diisi.',
            'durasi.integer' => 'Durasi kursus harus berupa bilangan bulat.',
            'durasi.min' => 'Durasi kursus tidak boleh dibawah 1.',
            'jam.required' => 'Durasi jam perhari wajib diisi.',
            'jam.integer' => 'Durasi jam perhari harus berupa bilangan bulat.',
            'jam.min' => 'Durasi jam perhari tidak boleh dibawah 1.',
            'jam.max' => 'Durasi jam perhari tak boleh lebih dari 6 jam'
        ]);

        // Cek jika ada file gambar yang diunggah
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $origin = $file->getClientOriginalName();
            $uniqName = time() . '_' . uniqid() . '_' . $origin;

            if (KursusModel::where('original_gambar', $origin)->where('id', '!=', $id)->exists()) {
                return redirect()->back()->with('error', 'Gambar ini sudah digunakan di kursus lain.')->withInput();
            }

            // Hapus file gambar lama jika ada
            if ($kursus->gambar && file_exists(public_path('assets/images/' . $kursus->gambar))) {
                unlink(public_path('assets/images/' . $kursus->gambar));
            }

            // Pindahkan file gambar baru ke folder assets/images
            $file->move(public_path('assets/images'), $uniqName);

            // Update nama file gambar di database
            $kursus->gambar = $uniqName;
        }

        try {
            // Update data kursus
            $kursus->update([
                'nama_krs' => $request->nama_krs,
                'gambar' => $kursus->gambar, // Tetap gunakan gambar lama jika tidak diubah
                'deskripsi' => $request->deskripsi,
                'biaya_krs' => $request->biaya_krs,
                'durasi' => $request->durasi,
                'jam' => $request->jam
            ]);
        
            // Sinkronisasi materi dengan kursus
            MateriModel::whereIn('id', $request->id_mtr)->update(['kursus_id' => $kursus->id]);
            MateriModel::whereNotIn('id', $request->id_mtr)->where('kursus_id', $kursus->id)->update(['kursus_id' => null]);

            return redirect('/courses')->with('success', 'Kursus berhasil diedit');
        } catch (\Exception $e) {
            return redirect('/courses')->with('error', 'Kursus gagal diedit.');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    $kursus = KursusModel::findOrFail($id);

    try {
        if ($kursus->gambar && file_exists(public_path('assets/images/' . $kursus->gambar))) {
            unlink(public_path('assets/images/' . $kursus->gambar));
        }
        // Set kursus_id di tabel materi menjadi null
        MateriModel::where('kursus_id', $kursus->id)->update(['kursus_id' => null]);
        $kursus->delete();

        return redirect()->route('courses.index')->with('success', 'Kursus berhasil dihapus.');
    } catch (\Exception $e) {
        if ($e->getCode() == 23000) {
            return redirect()->route('courses.index')->with('error', 'Kursus tidak dapat dihapus karena masih terkait dengan pendaftaran kursus.');
        }

        return redirect()->route('courses.index')->with("error", "Gagal menghapus kursus.");
    }
}

}
