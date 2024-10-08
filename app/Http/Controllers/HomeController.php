<?php

namespace App\Http\Controllers;

use App\Models\HistoryModel;
use App\Models\KtgMateriModel;
use App\Models\KursusModel;
use App\Models\MateriModel;
use App\Models\MuridModel;
use App\Models\PdKursusModel;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $studentCount = MuridModel::count();
        $categoryCount = KtgMateriModel::count();
        $courseCount = KursusModel::count();
        $materyCount = MateriModel::count();
        $regists = PdKursusModel::orderBy('created_at', 'desc')->take(5)->get();
        $activeCourses = PdKursusModel::where('tanggal_mulai', '<=', Carbon::now())
                                    ->where('tanggal_selesai', '>=', Carbon::now())
                                    ->count();
        $courseList = KursusModel::withCount('pendaftar')
                                    ->orderBy('created_at', 'desc')
                                    ->take(5)
                                    ->get();

        $revenueKursusLunas = PdKursusModel::where('status', 'lunas')->sum('biaya');

                                    // Step 2: Hitung pendapatan dari tabel history (kursus yang dihapus namun sudah lunas)
        $revenueHistory = HistoryModel::join('kursus', 'history.id_krs', '=', 'kursus.id')  // pastikan ada kolom yang menandakan status pembayaran
                        ->sum('kursus.biaya_krs');

                                    // Step 3: Gabungkan kedua pendapatan
        $revenue = $revenueKursusLunas + $revenueHistory;
        return view('home', 
        compact('studentCount', 'categoryCount', 'courseCount', 'materyCount', 'regists', 'activeCourses', 'revenue', 'courseList'));
    }
}
