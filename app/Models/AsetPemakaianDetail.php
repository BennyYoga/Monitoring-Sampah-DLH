<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsetPemakaianDetail extends Model
{
    use HasFactory;
    protected $table = 'aset_pemakaian_detail';
    protected $fillable = [
        'PakaiUuid', 'BarangUuid', 'Unit',
    ];

    public function Barang(){
        return $this->belongsTo(AsetBarang::class, 'BarangUuid', 'BarangUuid');
    }

    public function Pemakaian(){
        return $this->belongsTo(AsetPemakaian::class, 'PakaiUuid', 'PakaiUuid');
    }
}
