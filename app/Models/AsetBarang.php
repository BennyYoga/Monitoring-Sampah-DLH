<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsetBarang extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $table = 'aset_barang';
    protected $primaryKey = 'BarangUuid';
    protected $guarded = 'BarangUuid';
    protected $fillable = [
        'BarangUuid', 'AlatBeratId', 'JenisId', 'Nama', 'TotalUnit', 'Satuan',
    ];

    public function AsetJenis()
    {
        return $this->belongsTo(AsetJenis::class, 'JenisId', 'id');
    }
    public function Alat()
    {
        return $this->belongsTo(Alat::class, 'AlatId', 'AlatUuid');
    }
    public function Pembelian()
    {
        return $this->belongsToMany(AsetPembelian::class, 'aset_pembelian_detail', 'BarangUuid', 'BeliUuid');
    }
    public function Pemakaian()
    {
        return $this->belongsToMany(AsetPemakaian::class, 'aset_pemakaian_detail', 'BarangUuid', 'PakaiUuid');
    }
}
