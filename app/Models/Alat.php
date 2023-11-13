<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alat extends Model
{
    use HasFactory;
    protected $table = 'alat';
    protected $fillable = [
        'AlatUuid', 'Kode', 'JenisAlatBerat', 'Merk', 'NamaModel', 'NoSeri', 'TahunPerolehan', 'Keterangan', 
        'Foto', 'LastUpdateKondisi', 'LastUpdateFoto', 'LastUpdateKeterangan', 'created_at', 'updated_at'
    ];

    public function Kondisi()
    {
        return $this->belongsToMany(AlatKondisi::class, 'alat_kondisi_detail', 'AlatUuid', 'KondisiId');
    }

    public function Jenis()
    {
        return $this->belongsTo(AlatBeratJenis::class, 'JenisAlatBerat', 'JenisAlatBeratId');
    }

    public function AsetBarang()
    {
        return $this->hasMany(AsetBarang::class);
    }
}
