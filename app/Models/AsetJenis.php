<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsetJenis extends Model
{
    use HasFactory;
    protected $table = 'aset_jenis';
    protected $fillable = [
        'Nama', 'Bahan'
    ];

    public function AsetBarang()
    {
        return $this->hasMany(AsetBarang::class);
    }
}
