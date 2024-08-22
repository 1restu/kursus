<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\KtgMateriModel;
use App\Model\MateriModel;
use Illuminate\Database\QueryException;

class KtgMateriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategori = KtgMateriModel::latest('created_at')->get();
        return view('categories.index', compact('kategori'));
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
            'nama_ktg' => 'required|unique:ktg_materi,nama_ktg|regex:/^[a-zA-Z\s]+$/'
        ], [

            'nama_ktg.required' => 'Nama kategori harus di isi.',
            'nama_ktg.unique' => 'Kategori ini sudah ada, silahka masukan nama kategori yang berbeda.',
            'nama_ktg.regex' => 'Nama kategori tidak boleh memiliki angka.'
        ]);

        try{
            KtgMateriModel::create([
                'nama_ktg'=>$request->nama_ktg
            ]);

            return redirect('/categories')->with('success', 'Kategori baru berhasil ditambahkan.');
        } catch(\Exception $e) {
            return redirect('/categories')->with('error', 'Kategori baru gagal ditambahkan.');
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
        $ktg = KtgMateriModel::find($id);

        if(!$ktg) {
            return redirect('/categories')->with('error', 'Kategori tak ditemukan.');
        }

        $request->validate([
            'nama_ktg' => 'required|unique:ktg_materi,nama_ktg|regex:/^[a-zA-Z\s]+$/'
        ], [
            'nama_ktg.required' => 'Nama kategori harus di isi.',
            'nama_ktg.unique' => 'Kategori ini sudah ada, silahka masukan nama kategori yang berbeda.',
            'nama_ktg.regex' => 'Nama kategori tidak boleh memiliki angka.'
        ]);

        try{
            $ktg->update($request->only('nama_ktg'));
            return redirect('/categories')->with('success', 'Kategori berhasil di edit.');
        } catch(QueryException $e) {
            if($e->getcode() == '23000') {
                return redirect('/categories')->with('error', 'Kategori gagal di edit karna masih terkait dengan materi.');
            }
            return redirect('/categories')->with('error', 'Kategori gagal di edit.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    $ktg = KtgMateriModel::find($id);

    if (!$ktg) {
        return redirect('/categories')->with('error', 'Kategori tidak ditemukan.');
    }

    try {
        $ktg->delete();
        return redirect('/categories')->with('success', 'Kategori berhasil dihapus.');
    } catch (QueryException $e) {
        if($e->getCode() == '23000') {
            return redirect('/categories')->with('error', 'Kategori tidak dapat dihapus karena masih terkait dengan materi.');
        }
        return redirect('/categories')->with('error', 'Terjadi kesalahan. Kategori gagal dihapus.');
    }
}
}

