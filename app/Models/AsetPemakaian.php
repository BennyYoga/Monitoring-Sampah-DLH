<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsetPemakaian extends Model
{
    use HasFactory;
    protected $table = 'aset_pemakaian';
    protected $fillable = [
        'PakaiUuid', 'Tanggal'
    ];

    public function Barang()
    {
        return $this->belongsToMany(AsetBarang::class, 'aset_pemakaian_detail', 'PakaiUuid', 'BarangUuid');
    }
}
