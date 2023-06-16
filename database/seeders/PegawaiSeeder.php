<?php

namespace Database\Seeders;

use App\Models\Pegawai;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Pegawai::create([
            'id_kantor' => 1,
            'id_role' => 1,
            'NIP' => 123456,
            'nama_pegawai' => 'benny',
            'password' => Hash::make(123456),
        ]);
        Pegawai::create([
            'id_kantor' => 2,
            'id_role' => 2,
            'NIP' => 111111,
            'nama_pegawai' => 'Eki',
            'password' => Hash::make(111111),
        ]);
        Pegawai::create([
            'id_kantor' => 3,
            'id_role' => 2,
            'NIP' => 123,
            'nama_pegawai' => 'Haposan',
            'password' => Hash::make(123),
        ]);
    }
}
