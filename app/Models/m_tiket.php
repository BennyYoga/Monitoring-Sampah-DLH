<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class m_tiket extends Model
{
    use HasFactory;

    protected $table = 'tiket';

    protected $fillable = [
        'no_kendaraan', 'jenis_kendaraan', 'pengemudi', 'lokasi_sampah',
        'volume', 'id_kab_kota', 'jam_masuk', 'jam_keluar', 'id_pegawai',
    ];

    public function fk_kab_kot()
    {
        return $this->belongsTo(m_kabkota::class, 'id_kab_kota', 'id_kab_kota');
    }
    public function fk_pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai', 'id_pegawai');
    }

    public function grafik($tahun, $awal, $akhir, $id)
    {
        $result = DB::select(
            "SELECT
	b.selected_date,
    sum(b.total_volume) as total_volume
FROM
		(SELECT
            a.selected_date,
            ifnull(b.volume,0) as total_volume
        FROM
                (SELECT
                    EXTRACT(YEAR_MONTH FROM result.selected_date) as selected_date            
                FROM
                    (select 
                        * 
                    from 
                    (select adddate(:tahun,t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) selected_date from
                     (select 0 i union select 1 union select 2 union select 3 union select 4 
                      union select 5 union select 6 union select 7 union select 8 union select 9) t0,
                     (select 0 i union select 1 union select 2 union select 3 union select 4 
                      union select 5 union select 6 union select 7 union select 8 union select 9) t1,
                     (select 0 i union select 1 union select 2 union select 3 union select 4 
                      union select 5 union select 6 union select 7 union select 8 union select 9) t2,
                     (select 0 i union select 1 union select 2 union select 3 union select 4 
                      union select 5 union select 6 union select 7 union select 8 union select 9) t3,
                     (select 0 i union select 1 union select 2 union select 3 union select 4 
                      union select 5 union select 6 union select 7 union select 8 union select 9) t4) v
                    where selected_date between :awal and :akhir) as result
                 GROUP BY EXTRACT(YEAR_MONTH FROM result.selected_date)) a
            left join tiket as b on a.selected_date = EXTRACT(YEAR_MONTH FROM b.created_at) and b.id_kab_kota = :id
        order by EXTRACT(YEAR_MONTH FROM b.created_at) asc) b
   group by b.selected_date;",
            ['tahun' => $tahun, 'awal' => $awal, 'akhir' => $akhir, 'id' => $id]
        );
        return $result;
    }

    public function pie($awal, $akhir)
    {
        $result = DB::select(
            "SELECT
        kabupaten_kota.id_kab_kota,
        kabupaten_kota.nama_kab_kota,
        (SELECT	
            ifnull(sum(tiket.volume),0)
        FROM
            tiket 
        WHERE
            cast(tiket.created_at as DATE) >= :awal
             and tiket.id_kab_kota = kabupaten_kota.id_kab_kota
            and cast(tiket.created_at as DATE) <= :akhir) as Total 
    FROM
        kabupaten_kota;",
            ['awal' => $awal, 'akhir' => $akhir,]
        );

        return $result;
    }
}
