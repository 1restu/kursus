<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MuridModel extends Model
{
    use HasFactory;

    protected $table = 'murid';

    protected $fillable = [
        'nama',
        'no_tlp',
        'alamat'
    ];

    public function PdKursus()
    {
        return $this->hasMany(PdKursusModel::class, 'id_mrd');
    }
}
