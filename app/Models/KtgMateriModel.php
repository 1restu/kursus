<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KtgMateriModel extends Model
{
    use HasFactory;

    protected $table = 'ktg_materi';

    protected $fillable = [
        'nama_ktg'
    ];

    // public function Materi()
    // {
    //     return $this->hasMany(MateriModel::class, 'id_ktg');
    // }

    // public function Kursus()
    // {
    //     return $this->hasMany(KursusModel::class, 'id_ktg');
    // }
};
