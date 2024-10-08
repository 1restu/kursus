<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\KursusModel;
use App\Models\MuridModel;

class HistoryModel extends Model
{
    use HasFactory;

    protected $table = 'history';

    protected $fillable = [
        'id_krs',
        'nama_krs',
        'id_mrd',
        'nama',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
        'biaya_krs',
        'telepon'
    ];

    public function kursus()
    {
        return $this->belongsTo(KursusModel::class, 'id_krs');
    }

    // Relasi ke MuridModel
    public function murid()
    {
        return $this->belongsTo(MuridModel::class, 'id_mrd');
    }
}
