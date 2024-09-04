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
        'gambar',
        'deskripsi',
        'id_mtr',
        'biaya_krs',
        'durasi',
        'jam'
    ];

    public function materi()
    {
        return $this->belongsToMany(MateriModel::class, 'kursus_materi', 'id_krs', 'id_mtr')->withTimestamps();
    }

    public function pdkursus()
    {
        return $this->hasMany(PdKursusModel::class, 'id_krs');
    }

    public function pendaftar()
    {
        return $this->hasMany(PdKursusModel::class, 'id_krs', 'id');
    }

}
