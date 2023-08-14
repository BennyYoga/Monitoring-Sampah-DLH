<?php

namespace App\Http\Controllers;

use App\Models\m_kabkota;
use App\Models\m_tiket;
use Illuminate\Http\Request;
use \Yajra\Datatables\Datatables;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Mpdf\Mpdf;
use Mpdf\Mpdf as PDF;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\VarDumper\Cloner\Data;

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
        if ($optionKota != 'undefined') {
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
            $data = m_tiket::whereNotNull('jam_keluar')->orderBy('jam_masuk', 'asc');
        } else {
            $data = m_tiket::whereNotNull('jam_keluar')->where('id_pegawai', session('pegawai')->id_pegawai)->orderBy('jam_masuk', 'asc');
        }

        // Filter Kota
        if ($optionKota != 'undefined') {
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
        $option = new \stdClass();
        if($optionKota != 'undefined'){
            $optionKota = m_kabkota::where('id_kab_kota', $optionKota)->first();
            $optionKota = $optionKota->nama_kab_kota;
            $option->optionKota = $optionKota;
            $option->optionHari = $optionHari;
        }else{
            $option->optionKota = 'undefined';
            $option->optionHari = $optionHari;
        }
        $mpdf = new PDF(['orientation' => 'P', 'format' => 'A4',]);
        $mpdf->AddPageByArray([
            'margin-left' => 7,
            'margin-right' => 7,
            'margin-top' => 10,
            'margin-bottom' => 10,
        ]);
        $html = view('tiket.printRekap', compact('data', 'total','option'));
        $mpdf->writeHTML($html);
        $mpdf->Output("Rekap.pdf", "D");
    }

    public function exportExcel($optionKota, $optionHari)
    {
        // dd($optionHari, $optionKota);
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $namakota = m_kabkota::where('id_kab_kota', $optionKota)->first();
        $sheet->setCellValue('A1', 'PEMERINTAH DAERAH PROVINSI JAWA BARAT');
        $sheet->mergeCells('A1:P1');
        $sheet->setCellValue('A2', 'DINAS LINGKUNGAN HIDUP');
        $sheet->mergeCells('A2:P2');
        $sheet->setCellValue('A3', 'UPTD PENGELOLAAN SAMPAH TPA/TPST REGIONAL ' . session('pegawai')->fk_kantor->nama_kantor . '' );
        $sheet->mergeCells('A3:P3');
        $sheet->setCellValue('A4', session('pegawai')->fk_kantor->alamat_kantor);
        $sheet->mergeCells('A4:P4');
        $sheet->setCellValue('A5', ' ');
        $sheet->mergeCells('A5:P5');
        if($optionKota != 'undefined'){
            $sheet->setCellValue('A6', 'Untuk Wilayah : '.$namakota->nama_kab_kota.'');
            $sheet->mergeCells('A6:P6');
        }
        else{
            $sheet->setCellValue('A6', 'Untuk Wilayah : Semua Wilayah');
            $sheet->mergeCells('A6:P6');
        }
        if($optionHari != 'undefined'){
            $sheet->setCellValue('A7', 'Tanggal : '.$optionHari.'');
            $sheet->mergeCells('A7:P7');
        }
        else{
            $sheet->setCellValue('A7', 'Tanggal : Semua Tanggal');
            $sheet->mergeCells('A7:P7');
        }
        $sheet->setCellValue('A8', ' ');
        $sheet->mergeCells('A8:P8');

        
        if($optionKota != 'undefined'){
            $sheet->setCellValue('A9', 'No');
            $sheet->mergeCells('A9:A10');
            $sheet->setCellValue('B9', 'No Tiket');
            $sheet->mergeCells('B9:B10');
            $sheet->setCellValue('C9', 'Tanggal');
            $sheet->mergeCells('C9:C10');
            $sheet->setCellValue('D9', 'No Kendaraan');
            $sheet->mergeCells('D10:E10');
            $sheet->setCellValue('D10', 'Nomor');
            $sheet->setCellValue('E10', 'Jenis');
            $sheet->setCellValue('F9', 'Kode Surat Jalan');
            $sheet->mergeCells('F10:F10');
            $sheet->setCellValue('G9', 'Jam');
            $sheet->mergeCells('G9:H9');
            $sheet->setCellValue('G10', 'Masuk');
            $sheet->setCellValue('H10', 'Keluar');
            $sheet->setCellValue('I9', 'Nama Pengemudi');
            $sheet->mergeCells('I9:I10');
            $sheet->setCellValue('J9', 'Lokasi Sumber Sampah');
            $sheet->mergeCells('J9:J10');
            $sheet->setCellValue('K9', 'Volume');
            $sheet->setCellValue('K10', 'M3');
            $sheet->setCellValue('L9', 'Berat');
            $sheet->mergeCells('L9:N9');
            $sheet->setCellValue('L10', 'Bruto');
            $sheet->setCellValue('M10', 'Tara');
            $sheet->setCellValue('N10', 'Netto');
            $sheet->setCellValue('O9', 'Total Biaya');
            $sheet->mergeCells('O9:O10');
        }
        else{
            $sheet->setCellValue('A9', 'No');
            $sheet->mergeCells('A9:A10');
            $sheet->setCellValue('B9', 'Kab/Kota');
            $sheet->mergeCells('B9:B10');
            $sheet->setCellValue('C9', 'No Tiket');
            $sheet->mergeCells('C9:C10');
            $sheet->setCellValue('D9', 'Tanggal');
            $sheet->mergeCells('D9:D10');
            $sheet->setCellValue('E9', 'No Kendaraan');
            $sheet->mergeCells('E10:F10');
            $sheet->setCellValue('E10', 'Nomor');
            $sheet->setCellValue('F10', 'Jenis');
            $sheet->setCellValue('G9', 'Kode Surat Jalan');
            $sheet->mergeCells('G10:G10');
            $sheet->setCellValue('H9', 'Jam');
            $sheet->mergeCells('H10:I9');
            $sheet->setCellValue('H10', 'Masuk');
            $sheet->setCellValue('I10', 'Keluar');
            $sheet->setCellValue('J9', 'Nama Pengemudi');
            $sheet->mergeCells('J9:J10');
            $sheet->setCellValue('K9', 'Lokasi Sumber Sampah');
            $sheet->mergeCells('K9:K10');
            $sheet->setCellValue('L9', 'Volume');
            $sheet->setCellValue('L10', 'M3');
            $sheet->setCellValue('M9', 'Berat');
            $sheet->mergeCells('M9:O9');
            $sheet->setCellValue('M10', 'Bruto');
            $sheet->setCellValue('N10', 'Tara');
            $sheet->setCellValue('O10', 'Netto');
            $sheet->setCellValue('P9', 'Total Biaya');
            $sheet->mergeCells('P9:P10');
        }

        if (session('pegawai')->id_role == 1) {
            $data = m_tiket::whereNotNull('jam_keluar')->orderBy('jam_masuk', 'asc');
        } else {
            $data = m_tiket::whereNotNull('jam_keluar')->where('id_pegawai', session('pegawai')->id_pegawai)->orderBy('jam_masuk', 'asc');
        }

        // Filter Kota
        if ($optionKota !== 'undefined') {
            $data = $data->where('id_kab_kota', $optionKota);
        } else {
            $data = $data->whereNotNull('jam_keluar');
        }

        // Filter Berdasarkan Waktu
        if ($optionHari !== 'undefined') {
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

        $i = 11;
        if($optionKota != 'undefined'){
            foreach ($data as $item) {
                $sheet->setCellValue('A' . $i, $i-10);
                $sheet->setCellValue('B' . $i, $item->id);
                $sheet->setCellValue('C' . $i, date('d F Y', strtotime($item->jam_masuk)));
                $sheet->setCellValue('D' . $i, $item->no_kendaraan);
                $sheet->setCellValue('E' . $i, $item->jenis_kendaraan);
                $sheet->setCellValue('F' . $i, "-");
                $sheet->setCellValue('G' . $i, date('H:i:s', strtotime($item->jam_masuk)));
                $sheet->setCellValue('H' . $i, date('H:i:s', strtotime($item->jam_keluar)));
                $sheet->setCellValue('I' . $i, $item->pengemudi);
                $sheet->setCellValue('J' . $i, $item->lokasi_sampah);
                $sheet->setCellValue('K' . $i, $item->volume);
                $sheet->setCellValue('L' . $i, '0');
                $sheet->setCellValue('M' . $i, '0');
                $sheet->setCellValue('N' . $i, $item->tonase);
                $sheet->setCellValue('O' . $i, number_format($item->tonase * 50));
                $i++;
            };
    
            $sheet->setCellValue('A' . $i, 'Jumlah');
            $sheet->mergeCells('A'.$i. ':'.'J'.$i);
            $sheet->setCellValue('K' . $i, $total['Volume']);
            $sheet->setCellValue('L' . $i, '0');
            $sheet->setCellValue('M' . $i, '0');
            $sheet->setCellValue('N' . $i, $total['Tonase']);
            $sheet->setCellValue('O' . $i, 'Rp '. number_format($total['Tonase'] * 50));
        }
        else{
            foreach ($data as $item) {
                $sheet->setCellValue('A' . $i, $i-10);
                $sheet->setCellValue('B' . $i, $item->fk_kab_kot->nama_kab_kota);
                $sheet->setCellValue('C' . $i, $item->id);
                $sheet->setCellValue('D' . $i, date('d F Y', strtotime($item->jam_masuk)));
                $sheet->setCellValue('E' . $i, $item->no_kendaraan);
                $sheet->setCellValue('F' . $i, $item->jenis_kendaraan);
                $sheet->setCellValue('G' . $i, "-");
                $sheet->setCellValue('H' . $i, date('H:i:s', strtotime($item->jam_masuk)));
                $sheet->setCellValue('I' . $i, date('H:i:s', strtotime($item->jam_keluar)));
                $sheet->setCellValue('J' . $i, $item->pengemudi);
                $sheet->setCellValue('K' . $i, $item->lokasi_sampah);
                $sheet->setCellValue('L' . $i, $item->volume);
                $sheet->setCellValue('M' . $i, '0');
                $sheet->setCellValue('N' . $i, '0');
                $sheet->setCellValue('O' . $i, $item->tonase);
                $sheet->setCellValue('P' . $i, number_format($item->tonase * 50));
                $i++;
            };
    
            $sheet->setCellValue('A' . $i, 'Jumlah');
            $sheet->mergeCells('A'.$i. ':'.'J'.$i);
            $sheet->setCellValue('L' . $i, $total['Volume']);
            $sheet->setCellValue('M' . $i, '0');
            $sheet->setCellValue('N' . $i, '0');
            $sheet->setCellValue('O' . $i, $total['Tonase']);
            $sheet->setCellValue('P' . $i, 'Rp '. number_format($total['Tonase'] * 50));
        }

        $writer = new Xlsx($spreadsheet);
        // $writer->save('hello world.xlsx');
        $fileName = 'exported_data.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }
}
