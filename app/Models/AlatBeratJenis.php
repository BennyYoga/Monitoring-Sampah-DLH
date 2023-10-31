<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlatBeratJenis extends Model
{
    use HasFactory;
    protected $table = 'alat_berat_jenis';
    protected $fillable = [
        'Nama', 'Kode'
    ];


    public function Alat()
    {
        return $this->hasMany(Alat::class);
    }
}
