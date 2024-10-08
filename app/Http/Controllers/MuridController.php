<?php

namespace App\Http\Controllers;

use App\Models\MuridModel;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class MuridController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = MuridModel::query();

        // Jika ada input pencarian
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('no_tlp', 'like', "%{$search}%")
                  ->orWhere('alamat', 'like', "%{$search}%");
            });

            $students = $query->latest('created_at')->get();

            if ($students->isEmpty()) {
                return redirect()->route('students.index')
                                 ->with('error', 'Tidak ada hasil ditemukan untuk pencarian: ' . $search)
                                 ->withInput(); // Mengingatkan input pencarian sebelumnya
            }
        } else {
            $students = MuridModel::latest('created_at')->get();
        }

        return view('students.index', compact('students'));
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
            'nama' => 'required|string|regex:/^[a-zA-Z\s]+$/|min:5|max:20',
            'no_tlp' => 'required|unique:murid,no_tlp|regex:/^[0-9]+$/|min:10|max:15', // Validasi panjang nomor telepon
            'alamat' => 'required|string|min:10|max:255' // Validasi panjang alamat
        ], [
            'nama.required' => 'Nama murid harus diisi.',
            'nama.regex' => 'Nama murid tidak boleh memiliki angka.',
            'nama.min' => 'Nama murid harus memiliki minimal :min karakter.',
            'nama.max' => 'Nama murid tidak boleh melebihi :max karakter.',
            'no_tlp.required' => 'Nomor telepon harus diisi.',
            'no_tlp.unique' => 'Nomor telepon ini sudah ada, silahkan masukkan nomor telepon yang berbeda.',
            'no_tlp.regex' => 'Nomor telepon hanya boleh berisi angka.',
            'no_tlp.min' => 'Nomor telepon harus memiliki minimal :min digit.',
            'no_tlp.max' => 'Nomor telepon tidak boleh melebihi :max digit.',
            'alamat.required' => 'Alamat harus diisi.',
            'alamat.min' => 'Alamat harus memiliki minimal :min karakter.',
            'alamat.max' => 'Alamat tidak boleh melebihi :max karakter.'
        ]);
        
        try {
            MuridModel::create([
                'nama' => $request->nama,
                'no_tlp' => $request->no_tlp,
                'alamat' => $request->alamat
            ]);
        
            return redirect('/students')->with('success', 'Murid baru berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect('/students')->with('error', 'Murid baru gagal ditambahkan.');
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
        $student = MuridModel::find($id);

        if ($student->PdKursus()->exists()) {
            return redirect('/students')->with('error', 'data murid tak bisa di edit karna masih terkait dengan pendaftaran kursus.');
        }

        $request->validate([
            'nama' => 'required|string|regex:/^[a-zA-Z\s]+$/|min:5|max:20',
            'no_tlp' => 'required|unique:murid,no_tlp,' . $id . '|regex:/^[0-9]+$/|min:10|max:15', // Allow current student's phone number
            'alamat' => 'required|string|min:10|max:255' // Validasi panjang alamat
        ], [
            'nama.required' => 'Nama murid harus diisi.',
            'nama.regex' => 'Nama murid tidak boleh memiliki angka.',
            'nama.min' => 'Nama murid harus memiliki minimal :min karakter.',
            'nama.max' => 'Nama murid tidak boleh melebihi :max karakter.',
            'no_tlp.required' => 'Nomor telepon harus diisi.',
            'no_tlp.unique' => 'Nomor telepon ini sudah ada, silahkan masukkan nomor telepon yang berbeda.',
            'no_tlp.regex' => 'Nomor telepon hanya boleh berisi angka.',
            'no_tlp.min' => 'Nomor telepon harus memiliki minimal :min digit.',
            'no_tlp.max' => 'Nomor telepon tidak boleh melebihi :max digit.',
            'alamat.required' => 'Alamat harus diisi.',
            'alamat.min' => 'Alamat harus memiliki minimal :min karakter.',
            'alamat.max' => 'Alamat tidak boleh melebihi :max karakter.'
        ]);

        try {
            $student->update($request->only('nama', 'no_tlp', 'alamat'));
            return redirect('/students')->with('success', 'Murid berhasil diedit.');
        } catch (QueryException $e) {
            if ($e->getCode() == '23000') {
                return redirect('/students')->with('error', 'Murid gagal diedit karena masih terkait dengan data lain.');
            }
            return redirect('/students')->with('error', 'Murid gagal diedit.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $student = MuridModel::find($id);

        if (!$student) {
            return redirect('/students')->with('error', 'Murid tidak ditemukan.');
        }

        try {
            $student->delete();
            return redirect('/students')->with('success', 'Murid berhasil dihapus.');
        } catch (QueryException $e) {
            if($e->getCode() == '23000') {
                return redirect('/students')->with('error', 'Murid tidak dapat dihapus karena data murid masih terkait di pendaftaran kursus.');
            }
            return redirect('/students')->with('error', 'Terjadi kesalahan. Murid gagal dihapus.');
        }
    }
}
