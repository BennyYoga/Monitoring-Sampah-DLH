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

    public function DetailBarang()
    {
        return $this->hasMany(AsetPemakaianDetail::class, 'PakaiUuid', 'PakaiUuid');
    }
}
