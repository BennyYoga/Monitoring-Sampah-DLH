<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class m_kabkota extends Model
{
    use HasFactory;

    protected $table ='kabupaten_kota';
    protected $guarded = ['id'];
    protected $primaryKey = 'id_kab_kota';

    protected $fillable = [
        'nama_kab_kota',
    ];

    public function fk_tiket()
    {
        return $this->hasMany(m_tiket::class, 'id_kab_kota', 'id_kab_kota');
    }
}


