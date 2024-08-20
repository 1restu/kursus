<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MateriModel;
use App\Models\KtgMateriModel;

class KursusModel extends Model
{
    use HasFactory;

    protected $table = 'kursus';

    protected $fillable = [
        'nama_krs',
        'deskripsi',
        'id_ktg',
        'id_mtr',
        'biaya_krs',
        'durasi'
    ];

    public function materi()
    {
        return $this->belongTo(MateriModel::class, 'id_mtr');
    }

    public function kategori()
    {
        return $this->belongTo(KtgMateriModel::class, 'id_ktg');
    }

    public function Pdkursus()
    {
        return $this->hasMany(PdKursusModel::class, 'id_krs');
    }
}
