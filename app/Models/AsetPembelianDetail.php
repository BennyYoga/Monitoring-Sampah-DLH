<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsetPembelianDetail extends Model
{
    use HasFactory;
    protected $table = 'aset_pembelian_detail';
    protected $fillable = [
        'BeliUuid', 'BarangUuid', 'Unit', 'Harga'
    ];

    public function Barang(){
        return $this->belongsTo(AsetBarang::class, 'BarangUuid', 'BarangUuid');
    }

    public function Pembelian(){
        return $this->belongsTo(AsetPembelian::class, 'BeliUuid', 'BeliUuid');
    }
}
