<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    protected $table = 'history';

    protected $fillable = [
        'id_krs',
        'id_mrd',
        'tanggal_mulai',
        'tanggal_selesai',
        'hasil',
    ];
}
