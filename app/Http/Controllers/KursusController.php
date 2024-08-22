<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Models\KursusModel;

class KursusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kursus = KursusModel::latest('created_at');
        return view('', compact('kursus'));
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
            'nama_krs' => 'required|unique:kursus,nama_krs|regex:/^[a-zA-Z\s]+$/',
            'gambar' => 'required|image|max:5280|mimes:jpeg,png,jpg',
            'deskripsi' => 'required|unique:kursus,nama_krs|min:10',
            'id_mtr' => 'required|exists',

        ]);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
