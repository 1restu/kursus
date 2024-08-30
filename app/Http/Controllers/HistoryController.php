<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\HistoryModel;
use App\Models\KursusModel;
use App\Models\MuridModel;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $search = $request->input('search');
    $query = HistoryModel::query();

    if ($search) {
        $query->whereHas('murid', function($q) use ($search) {
            $q->where('nama', 'like', "%{$search}%");
        })->orWhereHas('kursus', function($q) use ($search) {
            $q->where('nama_krs', 'like', "%{$search}%");
        });

        $histories = $query->latest('created_at')->get();

        if ($histories->isEmpty()) {
            return redirect()->route('histories.index')
                             ->with('error', 'Tidak ada hasil ditemukan untuk pencarian: ' . $search)
                             ->withInput();
        }
    } else {
        $histories = HistoryModel::with('kursus', 'murid')->latest('created_at')->get();
    }

    return view('histories.index', compact('histories'));
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
        //
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
