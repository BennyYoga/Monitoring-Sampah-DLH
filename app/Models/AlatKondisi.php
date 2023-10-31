<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlatKondisi extends Model
{
    use HasFactory;
    protected $table = 'alat_kondisi';
    protected $fillable = [
        'Label', 'Keterangan'
    ];

    public function Alat()
    {
        return $this->belongsToMany(Alat::class, 'alat_kondisi_detail', 'KondisiId', 'AlatUuid');
    }
}
