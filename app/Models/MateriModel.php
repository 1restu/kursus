<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\KtgMateriModel;

class MateriModel extends Model
{
    use HasFactory;

    protected $table = 'materi';

    protected $fillable = [
        'nama_mtr',
        'deskripsi',
        'file_mtr',
        'id_ktg'
    ];

    public function kategori()
    {
        return $this->belongsTo(KtgMateriModel::class, 'id_ktg');
    }

    public function kursus()
    {
        return $this->belongsToMany(KursusModel::class, 'kursus_materi', 'id_mtr', 'id_krs')->withTimestamps();
    }
};