<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\KursusModel;
use App\Models\MuridModel;

class PdKursusModel extends Model
{
    use HasFactory;

    protected $table = 'pd_kursus';

    protected $fillable = [
        'id_krs',
        'id_mrd',
        'biaya',
        'status',
        'tanggal_mulai',
        'tanggal_selesai'
    ];

    protected $dates = [
        'tanggal_daftar', 'tanggal_mulai', 'tanggal_selesai'
    ];

    public function Kursus()
    {
        return $this->belongsTo(KursusModel::class, 'id_krs');
    }

    public function Murid()
    {
        return $this->belongsTo(MuridModel::class, 'id_mrd');
    }

}
