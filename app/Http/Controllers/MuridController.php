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
    public function index()
    {
        $students = MuridModel::latest('created_at')->get();
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
            'nama' => 'required|regex:/^[a-zA-Z\s]+$/|unique:murid,nama',
            'no_tlp' => 'required|unique:murid,no_tlp|regex:/^[0-9]+$/',
            'alamat' => 'required'
        ], [
            'nama.required' => 'Nama murid harus diisi.',
            'nama.regex' => 'Nama murid tidak boleh memiliki angka.',
            'nama.unique' => 'Nama murid sudah ada, silahkan masukkan nama yang berbeda',
            'no_tlp.required' => 'Nomor telepon harus diisi.',
            'no_tlp.unique' => 'Nomor telepon ini sudah ada, silahkan masukkan nomor telepon yang berbeda.',
            'no_tlp.regex' => 'Nomor telepon hanya boleh berisi angka.',
            'alamat.required' => 'Alamat harus diisi.'
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

        if (!$student) {
            return redirect('/students')->with('error', 'Murid tidak ditemukan.');
        }

        $request->validate([
            'nama' => 'required|regex:/^[a-zA-Z\s]+$/',
            'no_tlp' => 'required|unique:murid,no_tlp,' . $id . '|regex:/^[0-9]+$/', // Allow current student's phone number
            'alamat' => 'required'
        ], [
            'nama.required' => 'Nama murid harus diisi.',
            'nama.regex' => 'Nama murid tidak boleh memiliki angka.',
            'no_tlp.required' => 'Nomor telepon harus diisi.',
            'no_tlp.unique' => 'Nomor telepon ini sudah ada, silahkan masukkan nomor telepon yang berbeda.',
            'no_tlp.regex' => 'Nomor telepon hanya boleh berisi angka.',
            'alamat.required' => 'Alamat harus diisi.'
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
                return redirect('/students')->with('error', 'Murid tidak dapat dihapus karena data murid masih digunakan.');
            }
            return redirect('/students')->with('error', 'Terjadi kesalahan. Murid gagal dihapus.');
        }
    }
}
