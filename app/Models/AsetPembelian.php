<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AsetPembelian extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $table = 'aset_pembelian';
    protected $primaryKey = 'BeliUuid';
    protected $guarded = 'BeliUuid';
    protected $fillable = [
        'BeliUuid', 'Tanggal'
    ];

    public function Barang()
    {
        return $this->belongsToMany(AsetBarang::class, 'aset_pembelian_detail', 'BeliUuid', 'BarangUuid');
    }
    public function DetailBarang()
    {
        return $this->hasMany(AsetPembelianDetail::class, 'BeliUuid', 'BeliUuid');
    }
}