<?php

namespace App\Http\Controllers;

use App\Models\m_kabkota;
use App\Models\m_tiket;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use \Yajra\Datatables\Datatables;
use DateTime;

class c_tiket extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $date = date('Y-m-d');
        // $tiket = m_tiket::all();
        $tiket = m_tiket::whereNull('jam_keluar')->get();
        if ($request->ajax()) {
            $tiket = m_tiket::whereNull('jam_keluar');
            return DataTables::of($tiket)
                ->addColumn('nama_kab_kota', function ($row) {
                    $kab_kota = m_kabkota::where('id_kab_kota', $row->id_kab_kota)->first();
                    return $kab_kota->nama_kab_kota;
                })
                ->addColumn('jam_masuk', function ($row) {
                    $row->jam_masuk = date('H:i:s', strtotime($row->jam_masuk));
                    return $row->jam_masuk;
                })
                ->addColumn('jam_keluar', function ($row) {
                    if ($row->jam_keluar) {
                        $row->jam_keluar = date('H:i:s', strtotime($row->jam_keluar));
                    }
                    return $row->jam_keluar;
                })
                ->addColumn('action', function ($row) {
                    $btn = '';
           

                    if ($row->jam_keluar === null) {
                        $btn .= '<form action="' . route('tiket.update', ['id' => $row->id]) . '" method="POST">';
                        $btn .= '<input type="hidden" name="_method" value="PUT">';
                        $btn .= csrf_field();
                        $btn .= '<button type="submit" class="btn btn-success" data-confirm-swal="true" data-confirm-title="Delete User!" data-confirm-text="Are you sure you want to delete?" style="font-size: 15px">Selesai</button>';
                        $btn .= '</form>';
                    } else {
                        $btn .= '';
                    }

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('tiket.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kabkota = m_kabkota::All();
        return view('tiket.form', compact('kabkota'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'no_kendaraan' => 'required',
                'jenis_kendaraan' => 'required',
                'pengemudi' => 'required',
                'lokasi_sampah' => 'required',
                'volume' => 'required',
                'id_kab_kota' => 'required',
            ]
        );
        $data = $request->all();
        $data['id_kab_kota'] = (int)$data['id_kab_kota'];

        $waktu = new DateTime();
        $data['jam_masuk'] = $waktu;
        m_tiket::create($data);
        return redirect()->route('tiket.index')->withToastSuccess('Berhasil Menambahkan Tiket');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tiket=m_tiket::findOrfail($id);    
        return view('tiket.detail', compact('tiket'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tiket = m_tiket::find($id);
        if (!$tiket) return redirect()->route('tiket.index')
            ->with('error_message', 'tiket dengan id' . $id . ' tidak ditemukan');
        return view('tiket.edit', compact('tiket'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $tiket = m_tiket::where('id', $id)->first();
        $data = [
            'no_kendaraan' => $tiket['no_kendaraan'],
            'jenis_kendaraan' => $tiket['jenis_kendaraan'],
            'pengemudi' => $tiket['pengemudi'],
            'lokasi_sampah' => $tiket['lokasi_sampah'],
            'jam_masuk' => $tiket['jam_masuk'],
            'volume' => $tiket['volume'],
        ];
        $waktu = new DateTime();
        $data['jam_keluar'] = $waktu;
        // dd($data);
        m_tiket::where('id', $id)->update($data);

        return redirect()->route('tiket.index')->withToastSuccess('Berhasil Memperbarui tiket');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function rekap(Request $request)
    {
        if ($request->ajax()) {
            $tiket = m_tiket::whereNotNull('jam_keluar');

            if (!empty($filterKabkota)) {
                $tiket->whereHas('id_kab_kota', function ($query) use ($filterKabkota) {
                    $query->where('nama_kab_kota', $filterKabkota);
                });
            }

            $tiket = $tiket->get();

            return DataTables::of($tiket)
                ->addColumn('bulan', function ($row) {
                    $tanggal = date('d', strtotime($row->jam_keluar));
                    $namaBulan = date('F', strtotime($row->jam_keluar));
                    $bulan = $tanggal . ' ' . $namaBulan;
                    return $bulan;
                })
                ->addColumn('jam_masuk', function ($row) {
                    $row->jam_masuk = date('H:i:s', strtotime($row->jam_masuk));
                    return $row->jam_masuk;
                })
                ->addColumn('jam_keluar', function ($row) {
                    if ($row->jam_keluar) {
                        $row->jam_keluar = date('H:i:s', strtotime($row->jam_keluar));
                    }
                    return $row->jam_keluar;
                })
                ->addColumn('nama_kab_kota', function ($row) {
                    $kab_kota = m_kabkota::where('id_kab_kota', $row->id_kab_kota)->first();
                    return $kab_kota->nama_kab_kota;
                })
                ->addColumn('action', function ($row) {
                    $tiket = m_tiket::all();
                    $btn = '';
                    $btn = '<a href=' . route('tiket.detail', $row->id) . ' style="font-size:20px" class="text-warning mr-10"><i class="lni lni-pencil-alt"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $kab_kota = m_kabkota::all();

        return view('tiket.rekap', compact('kab_kota'));
    }

    public function rekapData(Request $request, $optionKota, $optionHari)
    {
        $data = null; // Inisialisasi variabel $data dengan null

        // Filter Kota
        if ($optionKota != 'default') {
            $data = m_tiket::whereNotNull('jam_keluar')->where('id_kab_kota', $optionKota);
        } else {
            $data = m_tiket::whereNotNull('jam_keluar');
        }

        // Filter Berdasarkan Waktu
        if ($optionHari == 'Hari') {
            $date = date('Y-m-d');
            $data = $data->whereDate('jam_keluar', $date);
        } else if ($optionHari == 'Bulan') {
            $date = date('Y-m');
            $data = $data->whereYear('jam_keluar', '=', date('Y'))
                ->whereMonth('jam_keluar', '=', date('m'));
        } else if ($optionHari == 'Tahun') {
            $date = date('Y');
            $data = $data->whereYear('jam_keluar', $date);
        }

        $data = $data->get(); // Eksekusi query dan ambil data

        // Melanjutkan pemrosesan data selanjutnya...


        if ($request->ajax()) {
            return DataTables::of($data)
                ->addColumn('bulan', function ($row) {
                    $tanggal = date('d', strtotime($row->jam_keluar));
                    $namaBulan = date('F', strtotime($row->jam_keluar));
                    $bulan = $tanggal . ' ' . $namaBulan;
                    return $bulan;
                })
                ->addColumn('jam_masuk', function ($row) {
                    $row->jam_masuk = date('H:i:s', strtotime($row->jam_masuk));
                    return $row->jam_masuk;
                })
                ->addColumn('jam_keluar', function ($row) {
                    if ($row->jam_keluar) {
                        $row->jam_keluar = date('H:i:s', strtotime($row->jam_keluar));
                    }
                    return $row->jam_keluar;
                })
                ->addColumn('nama_kab_kota', function ($row) {
                    $kab_kota = m_kabkota::where('id_kab_kota', $row->id_kab_kota)->first();
                    return $kab_kota->nama_kab_kota;
                })
                ->addColumn('action', function ($row) {
                    $tiket = m_tiket::all();
                })
                ->make(true);
        }

        return response()->json(['data' => $data]);
    }
}
