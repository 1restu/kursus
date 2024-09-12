<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\KtgMateriModel;
use App\Models\KursusModel;

class MateriModel extends Model
{
    use HasFactory;

    protected $table = 'materi';

    protected $fillable = [
        'nama_mtr',
        'deskripsi',
        'file_mtr',
        'original_file_mtr',
        'id_ktg'
    ];

    // Relasi many-to-one: Satu materi hanya memiliki satu kursus
    public function kursus()
    {
        return $this->belongsTo(KursusModel::class, 'kursus_id');
    }

    public function kategori()
    {
        return $this->belongsTo(KtgMateriModel::class, 'id_ktg');
    }

}
