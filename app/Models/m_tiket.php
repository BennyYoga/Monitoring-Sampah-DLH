<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class m_tiket extends Model
{
    use HasFactory;

    protected $table ='tiket';

    protected $fillable = [
        'no_kendaraan', 'jenis_kendaraan', 'pengemudi', 'lokasi_sampah',
        'volume', 'id_kab_kota', 'jam_masuk', 'jam_keluar', 'id_pegawai',
    ];
        
}
