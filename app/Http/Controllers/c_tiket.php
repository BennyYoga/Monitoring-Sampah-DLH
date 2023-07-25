<?php

namespace App\Http\Controllers;

use App\Models\m_kabkota;
use App\Models\m_tiket;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use \Yajra\Datatables\Datatables;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Mpdf\Mpdf;
use Mpdf\Mpdf as PDF;


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
                        $btn .= '<button type="submit" class="btn btn-success" id="printTiket" style="font-size: 15px">Selesai</button>';
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
        $user = Auth::user();
        $data['id_pegawai'] = $user->id_pegawai;
        $waktu = new DateTime();
        $data['jam_masuk'] = $waktu;
        m_tiket::create($data);
        return redirect()->route('tiket.index')->withToastSuccess('Berhasil Menambahkan Tiket');
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
        $tiket = m_tiket::findOrFail($id);
        $waktu = new DateTime();
        $user = Auth::user();

        $tiket->jam_keluar = $waktu;
        $tiket->save();

        $tiket->tonase = 0;
        if ($tiket->volume <= 5) {
            $tiket->tonase = 0;
        } elseif ($tiket->volume <= 8) {
            $tiket->tonase = 2856;
        } elseif ($tiket->volume <= 11) {
            $tiket->tonase = 4760;
        } elseif ($tiket->volume <= 24) {
            $tiket->tonase = 5712;
        } elseif ($tiket->volume <= 30) {
            $tiket->tonase = 11900;
        }


        $mpdf = new Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'margin_left' => '20', 'margin_right' => '20', 'margin-bottom' => '10']);
        $view = view('tiket.detail', compact('tiket', 'user',))->render();
        $mpdf->WriteHTML($view);
        $filename = $tiket->pengemudi . '.pdf';
        $mpdf->Output($filename, 'I');
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
            if (session('pegawai')->id_role == 1) {
                $tiket = m_tiket::whereNotNull('jam_keluar');
            } else {
                $tiket = m_tiket::whereNotNull('jam_keluar')->where('id_pegawai', session('pegawai')->id_pegawai);
            }

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
                    $tahun = date('Y', strtotime($row->jam_keluar));
                    $bulan = $tanggal . ' ' . $namaBulan . ' ' . $tahun;
                    return [
                        'display' => $bulan,
                        'timestamp' => strtotime($row->jam_keluar)
                    ];
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
                    return '<a href=' . route('tiket.print', $row->id) . ' class="btn btn-primary" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">Print</a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $kab_kota = m_kabkota::all();

        return view('tiket.rekap', compact('kab_kota'));
    }

    public function rekapData(Request $request, $optionKota, $optionHari)
    {
        $data = null;
        if (session('pegawai')->id_role == 1) {
            $data = m_tiket::whereNotNull('jam_keluar');
        } else {
            $data = m_tiket::whereNotNull('jam_keluar')->where('id_pegawai', session('pegawai')->id_pegawai);
        }

        // Filter Kota
        if ($optionKota != 'default') {
            $data = $data->where('id_kab_kota', $optionKota);
        } else {
            $data = $data->whereNotNull('jam_keluar');
        }

        // Filter Berdasarkan Waktu
        if ($optionHari != 'undefined') {
            $dateArray = explode(" - ", $optionHari);
            $dateArray[0] = trim($dateArray[0]);
            $dateArray[1] = trim($dateArray[1]);
            $dateArray[0] .= ' 00:00:00';
            $dateArray[1] .= ' 23:59:59';

            $data = $data->where('jam_keluar', '>=', $dateArray[0])
                ->where('jam_keluar', '<=', $dateArray[1])
                ->get();
        } else {
            $data = $data->get();
        }

        if ($request->ajax()) {
            return DataTables::of($data)
                ->addColumn('bulan', function ($row) {
                    $tanggal = date('d', strtotime($row->jam_keluar));
                    $namaBulan = date('F', strtotime($row->jam_keluar));
                    $tahun = date('Y', strtotime($row->jam_keluar));
                    $bulan = $tanggal . ' ' . $namaBulan . ' ' . $tahun;
                    return [
                        'display' => $bulan,
                        'timestamp' => strtotime($row->jam_keluar)
                    ];
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
                    return '<a href=' . route('tiket.print', $row->id) . ' class="btn btn-primary" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">Print</a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return response()->json(['data' => $data]);
    }

    public function tiketPrint($id)
    {
        $tiket = m_tiket::findOrFail($id);
        $user = Auth::user();

        $tiket->jam_keluar = new DateTime($tiket->jam_keluar);

        $tiket->tonase = 0;
        if ($tiket->volume <= 5) {
            $tiket->tonase = 0;
        } elseif ($tiket->volume <= 8) {
            $tiket->tonase = 2856;
        } elseif ($tiket->volume <= 11) {
            $tiket->tonase = 4760;
        } elseif ($tiket->volume <= 24) {
            $tiket->tonase = 5712;
        } elseif ($tiket->volume <= 30) {
            $tiket->tonase = 11900;
        }


        $mpdf = new Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'margin_left' => '20', 'margin_right' => '20', 'margin-bottom' => '10']);
        $view = view('tiket.detail', compact('tiket', 'user',))->render();
        $mpdf->WriteHTML($view);
        $filename = $tiket->pengemudi . '.pdf';
        $mpdf->Output($filename, 'I');
    }

    public function rekapPrint($optionKota, $optionHari)
    {

        if (session('pegawai')->id_role == 1) {
            $data = m_tiket::whereNotNull('jam_keluar');
        } else {
            $data = m_tiket::whereNotNull('jam_keluar')->where('id_pegawai', session('pegawai')->id_pegawai);
        }

        // Filter Kota
        if ($optionKota != 'default') {
            $data = $data->where('id_kab_kota', $optionKota);
        } else {
            $data = $data->whereNotNull('jam_keluar');
        }

        // Filter Berdasarkan Waktu
        if ($optionHari != 'undefined') {
            $dateArray = explode(" - ", $optionHari);
            $dateArray[0] = trim($dateArray[0]);
            $dateArray[1] = trim($dateArray[1]);
            $dateArray[0] .= ' 00:00:00';
            $dateArray[1] .= ' 23:59:59';

            $data = $data->where('jam_keluar', '>=', $dateArray[0])
                ->where('jam_keluar', '<=', $dateArray[1])
                ->get();
        } else {
            $data = $data->get();
        }

        $total = [
            'Volume' => 0,
            'Tonase' => 0,
        ];

        foreach ($data as $dataItem) {
            $volume = $dataItem->volume;
            if ($volume <= 5) {
                $dataItem->tonase = 0;
            } elseif ($volume <= 8) {
                $dataItem->tonase = 2856;
            } elseif ($volume <= 11) {
                $dataItem->tonase = 4760;
            } elseif ($volume <= 24) {
                $dataItem->tonase = 5712;
            } elseif ($volume <= 30) {
                $dataItem->tonase = 11900;
            }

            $total['Tonase'] += $dataItem->tonase;
            $total['Volume'] += $dataItem->volume;
        }
        $mpdf = new PDF(['orientation' => 'P', 'format' => 'A4',]);
        $mpdf->AddPageByArray([
            'margin-left' => 7,
            'margin-right' => 7,
            'margin-top' => 10,
            'margin-bottom' => 10,
        ]);
        $html = view('tiket.printRekap', compact('data', 'total'));
        $mpdf->writeHTML($html);
        $mpdf->Output("Rekap.pdf", "D");
    }
}
