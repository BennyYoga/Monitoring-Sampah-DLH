<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class m_kabkota extends Model
{
    use HasFactory;

    protected $table ='kabupaten_kota';

    protected $fillable = [
        'id_kab_kota',
        'nama_kab_kota',
    ];
}


