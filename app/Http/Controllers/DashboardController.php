<?php

namespace App\Http\Controllers;

use App\Models\m_kabkota;
use App\Models\m_tiket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $today = date('Y-m-d');
        $tiket['Day'] = m_tiket::whereDate('jam_masuk', $today)->get();
        $today = date('m');
        $tiket['Month'] = m_tiket::whereMonth('jam_masuk', $today)->get();

        $berat = [
            'hari' => 0,
            'bulan' => 0
        ];

        $iteration = ['hari' => 0, 'bulan' => 0];
        foreach ($tiket['Day'] as $tiket['Day']) {
            $berat['hari'] += $tiket['Day']->volume;
            $iteration['hari'] += 1;
        }
        foreach ($tiket['Month'] as $tiket['Month']) {
            $berat['bulan'] += $tiket['Month']->volume;
            $iteration['bulan'] += 1;
        }
        // Membuat indeks array kembali secara berurutan
        //Rekapitulasi data
        $today = date('Y-m-d');
        $rekap = m_tiket::where('jam_masuk', 'like', $today . '%')
        ->groupBy('id_kab_kota', 'jam_masuk')
        ->select('id_kab_kota', 'jam_masuk', DB::raw('SUM(volume) as volume'))
        ->get();
        
        $data = [];
        foreach ($rekap as $dataTiket) {
            $id_kab_kota = $dataTiket->id_kab_kota;
            $tanggal = $dataTiket->jam_masuk;
            $volume = $dataTiket->volume;

            if (!isset($data[$id_kab_kota])) {
                $data[$id_kab_kota] = [
                    'id_kab_kota' => $id_kab_kota,
                    'data_per_hari' => []
                ];
            }

            $data[$id_kab_kota]['data_per_hari'][] = [
                'tanggal' => $tanggal,
                'volume' => $volume,
                'jumlah_data' => 1
            ];
        }

        $data = array_values($data);

        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('kabkot', function ($row) {
                    $nama =  m_kabkota::where('id_kab_kota', $row['id_kab_kota'])->first();
                    return $nama->nama_kab_kota;
                })
                ->addColumn('volume', function ($row) {
                    $volume = 0;
                    foreach ($row['data_per_hari'] as $data) {
                        $volume += $data['volume'];
                    }
                    return $volume;
                })
                ->addColumn('jumlah', function ($row) {
                    $jumlahData = 0;
                    foreach ($row['data_per_hari'] as $data) {
                        $jumlahData += 1;
                    }
                    return $jumlahData;
                })
                ->make(true);
        }

        return view('Dashboard.index', compact('iteration', 'berat'));
    }
}
