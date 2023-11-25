<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\AlatBeratJenis;
use App\Models\AlatKondisi;
use DateTime;
use Faker\Provider\Uuid;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;

class AlatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $alat = Alat::all();
            return DataTables::of($alat)
                ->addColumn('JenisAlatBerat', function ($row) {
                    return $row->Jenis->Nama;
                })
                ->addColumn('Keterangan', function ($row) {
                    $data = "";
                    switch ($row->Keterangan) {
                        case '0':
                            return $data = "Beroperasi";
                            break;
                        case '1':
                            return $data = "Beroperasi segera dilakukan perbaikan";
                            break;
                        case '2':
                            return $data = "Breakdown/dapat dilakukan perbaikan";
                            break;
                        case '3':
                            return $data = "Breakdown/dapat dilakukan perbaikan";
                            break;
                        default:
                            return $data = "Tidak Ada Keterangan";
                            break;
                    }
                    return $data;
                })
                ->addColumn('TahunPerolehan', function ($row) {
                    $date = new DateTime($row->TahunPerolehan);
                    $monthName = $date->format('F');
                    $year = $date->format('Y');

                    return $monthName . ' ' . $year;
                })
                ->addColumn('UpdateTerakhir', function ($row) {
                    // $latestUpdate = collect([$row->LastUpdateKondisi, $row->LastUpdateFoto, $row->LastUpdateKeterangan])->max();
                    return date('d F Y H:i:s', strtotime($row->LastUpdateKeterangan));
                })
                ->addColumn('action', function ($row) {

                    $kondisiListDetail = DB::table('alat_kondisi_detail')->where('AlatUuid', $row->AlatUuid)->pluck('KondisiId')->toArray();
                    $kondisi = AlatKondisi::whereIn('KondisiId', $kondisiListDetail)->orderBy('Label', 'asc')->get();

                    $row->Kondisi = $kondisi->pluck('Label')->toArray();
                    $row->JenisAlatBerat = $row->Jenis->Nama;

                    $date = new DateTime($row->TahunPerolehan);
                    $monthName = $date->format('F');
                    $year = $date->format('Y');
                    $row->TahunPerolehan = $monthName . ' ' . $year;

                    switch ($row->Keterangan) {
                        case 0:
                            $row->Keterangan = "Beroperasi";
                            break;
                        case 1:
                            $row->Keterangan = "Beroperasi segera dilakukan perbaikan";
                            break;
                        case 2:
                            $row->Keterangan = "Breakdown/dapat dilakukan perbaikan";
                            break;
                        case 3:
                            $row->Keterangan = "Breakdown/dapat dilakukan perbaikan";
                            break;
                    }

                    $btn = '<a href=' . route('alat.show', $row->AlatUuid) . '  data-id=\'' . $row . '\' style="font-size:20px" class="text-primary mr-10" onClick="notificationDetailAlat(event,this)"><i class="lni lni-eye"></i></a>';
                    $btn .= '<a href=' . route('alat.edit', $row->AlatUuid) . '  style="font-size:20px" class="text-warning mr-10"><i class="lni lni-pencil-alt"></i></a>';
                    $btn .= '<a href=' . route('alat.destroy', $row->AlatUuid) . ' style="font-size:20px" class="text-danger mr-10" onClick="notificationBeforeDelete(event,this)"><i class="lni lni-trash-can"></i></a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('Alat.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $jenis_alat_berat = AlatBeratJenis::all();
        $kondisi = AlatKondisi::orderBy('Label', 'asc')->get();

        //Manipulasi File Temporary dan sesion preview Image
        $folderPath = public_path('images/temp/');
        File::cleanDirectory($folderPath);

        return view('Alat.form', compact('jenis_alat_berat', 'kondisi'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $uuid = Uuid::uuid();

        if ($request->Keterangan == null || $request->JenisAlatBeratId == null) {
            $message = "";
            if ($request->Keterangan == '-') {
                $message = 'Keterangan Harus Diisi';
            };
            if ($request->JenisAlatBeratId == '-') {
                $message = 'Jenis Alat Berat Harus Diisi';
            };
            Alert::error('Error', $message);
            return redirect()->route('alat.create');
        }

        //Penentuan dan Pengecekan Kode
        $NumberCode = Alat::where('JenisAlatBerat', $request->JenisAlatBeratId)->orderBy('Kode', 'desc')->first();
        if ($NumberCode != null) {
            $NumberCode = $NumberCode->Kode;
            preg_match('/([a-zA-Z]+)([0-9]+)/', $NumberCode, $matches);
            $NumberCode = $matches[2] + 1;
            $NewNumberCode = $matches[1] . $NumberCode;
        } else {
            $NumberCode = AlatBeratJenis::where('JenisAlatBeratId', $request->JenisAlatBeratId)->orderBy('Kode', 'desc')->first()->Kode;
            $NewNumberCode = $NumberCode . "1";
        }

        if ($request->Foto != null) {
            $image = $request->file('Foto');
            $imageName = $uuid . '.' . $image->extension();
            $image->move(public_path('images/alatBerat/'), $imageName);
            $location = 'images/alatBerat/' . $imageName;
        } else {
            $location = null;
        }

        $data = [
            'AlatUuid' => $uuid,
            'Kode' => $NewNumberCode,
            'JenisAlatBerat' => (int) $request->JenisAlatBeratId,
            'Merk' => $request->Merk,
            'NoSeri' => $request->NoSeri,
            'NamaModel' => $request->NamaModel,
            'TahunPerolehan' => $request->TahunPerolehan . '-01',
            'Keterangan' => (int) $request->Keterangan,
            'Foto' => $location,
            'LastUpdateKondisi' => date('Y-m-d H:i:s'),
            'LastUpdateFoto' => date('Y-m-d H:i:s'),
            'LastUpdateKeterangan' => date('Y-m-d H:i:s'),
        ];
        Alat::create($data);

        if ($request->Kondisi != null) {
            foreach ($request->Kondisi as $kondisi) {
                $kondisi_detail = [
                    'KondisiDetailUuid' => Uuid::uuid(),
                    'AlatUuid' => $uuid,
                    'KondisiId' => $kondisi,
                ];
                DB::table('alat_kondisi_detail')->insert($kondisi_detail);
            }
        }
        Alert::success('Success', 'Berhasil menambahkan data alat baru');
        return redirect()->route('alat.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $alat = Alat::where('AlatUuid', $id)->first();

        $konsiDetailList = DB::table('alat_kondisi_detail')->where('AlatUuid', $id)->pluck('KondisiId')->toArray();
        $kondisi = AlatKondisi::orderBy('Label', 'asc')->get();
        $dataKondisi = [];
        foreach ($kondisi as $value) {
            if (in_array($value->KondisiId, $konsiDetailList)) {
                $isiData = [
                    'KondisiId' => $value->KondisiId,
                    'Label' => $value->Label,
                    'selected' => true,
                ];
                array_push($dataKondisi, $isiData);
            } else {
                $isiData = [
                    'KondisiId' => $value->KondisiId,
                    'Label' => $value->Label,
                    'selected' => false,
                ];
                array_push($dataKondisi, $isiData);
            }
        };
        $jenis_alat_berat = AlatBeratJenis::where('JenisAlatBeratId', $alat->JenisAlatBerat)->first();
        $kondisi = AlatKondisi::orderBy('Label', 'asc')->get();

        //Manipulasi File Temporary dan sesion preview Image
        $folderPath = public_path('images/temp/');
        File::cleanDirectory($folderPath);

        list($tahun, $bulan) = sscanf($alat->TahunPerolehan, "%d-%d");
        $bulan = str_pad($bulan, 2, '0', STR_PAD_LEFT);
        $alat->TahunPerolehan = $tahun . '-' . $bulan;
        return view('Alat.edit', compact('jenis_alat_berat', 'kondisi', 'alat', 'kondisi', 'dataKondisi'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //

        $alatBefore = Alat::where('AlatUuid', $id)->first();
        $keteranganUpdate = null;
        $kondisiUpdate = null;
        $FotoUpdate = null;
        $locationFile = null;

        //Pengecekan Prubahan Keterangan
        if ($alatBefore->Keterangan != (int)$request->Keterangan) {
            $keteranganUpdate = date('Y-m-d H:i:s');
        } else {
            $keteranganUpdate = $alatBefore->LastUpdateKeterangan;
        }

        //Pengecekan Perubahan Kondisi
        $kondisiBefore = DB::table('alat_kondisi_detail')->where('AlatUuid', $id)->pluck('KondisiId')->toArray();
        if ($kondisiBefore != $request->Kondisi) {
            $kondisiUpdate = date('Y-m-d H:i:s');
        } else {
            $kondisiUpdate = $alatBefore->LastUpdateKondisi;
        }

        //pengecekan Perubahan Foto
        if ($request->Foto != null) {
            if (file_exists(public_path($alatBefore->Foto))) {
                unlink(public_path($alatBefore->Foto));
            }
            $image = $request->file('Foto');
            $imageName = $id . '.' . $image->extension();
            $image->move(public_path('images/alatBerat/'), $imageName);
            $locationFile = 'images/alatBerat/' . $imageName;
            $FotoUpdate = date('Y-m-d H:i:s');
        } else {
            $locationFile = $alatBefore->Foto;
            $FotoUpdate = $alatBefore->LastUpdateFoto;
        }

        //Pengecekan Perubahan Tahun Perolehan]
        $tahunPerolehan = null;
        if ($alatBefore->TahunPerolehan != $request->TahunPerolehan) {
            $tahunPerolehan = $request->TahunPerolehan . '-01';
        } else {
            $tahunPerolehan = $alatBefore->TahunPerolehan;
        }

        $data = [
            'Kode' => $alatBefore->Kode,
            'JenisAlatBerat' => $alatBefore->JenisAlatBerat,
            'Merk' => $request->Merk,
            'NoSeri' => $request->NoSeri,
            'NamaModel' => $request->NamaModel,
            'TahunPerolehan' => $tahunPerolehan,
            'Keterangan' => (int) $request->Keterangan,
            'Foto' => $locationFile,
            'LastUpdateKondisi' => $kondisiUpdate,
            'LastUpdateFoto' => $FotoUpdate,
            'LastUpdateKeterangan' => $keteranganUpdate,
        ];

        Alat::where('AlatUuid', $id)->update($data);

        DB::table('alat_kondisi_detail')->where('AlatUuid', $id)->delete();
        if ($request->Kondisi != null) {
            foreach ($request->Kondisi as $kondisi) {
                $kondisi_detail = [
                    'KondisiDetailUuid' => Uuid::uuid(),
                    'AlatUuid' => $id,
                    'KondisiId' => $kondisi,
                ];
                DB::table('alat_kondisi_detail')->insert($kondisi_detail);
            }
        }

        Alert::success('Success', 'Berhasil mengubah data alat');
        return redirect()->route('alat.index');
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
        try {

            $path = Alat::where('AlatUuid', $id)->first()->Foto;
            if (file_exists(public_path($path))) {
                unlink(public_path($path));
            }
            DB::table('alat_kondisi_detail')->where('AlatUuid', $id)->delete();
            Alat::where('AlatUuid', $id)->delete();
            Alert::success('Success', 'Berhasil menghapus data alat');
            return redirect()->route('alat.index');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1451) {
                Alert::error('Error', 'Gagal menghapus data Alat, karena data masih digunakan dalam suku cadang');
                return redirect()->route('alat.index');
            } else {
                Alert::error('Error', 'Terjadi Keasalahan ' . $e->getMessage());
                return redirect()->route('alat.index');
            }
        }
    }

    public function uploadImage(Request $request)
    {
        $image = $request->file('file');
        $imageName = time() . '.' . $image->extension();
        $image->move(public_path('images/temp/'), $imageName);

        return response()->json(['success' => $imageName]);
    }

    public function getDetail($id)
    {
        $data = Alat::where('AlatUuid', $id)->first();
        return response()->json(['data' => $data]);
    }

    public function export()
    {
        $spreadsheet = new Spreadsheet();

        $sheet1 = $spreadsheet->getActiveSheet();
        $sheet1->setTitle('Data Alat Berat1');
        $sheet1->setCellValue('A1', 'Data 1');

        $data = [
            ['Nama' => 'kehed', 'Deskripsi' => 'Anjay'],
            // Tambahkan data lain sesuai kebutuhan
        ];

        $html = view('Alat/Export/alatExport', ['data' => $data])->render();

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Html();
        $spreadsheet = $reader->loadFromString($html);

        // Menambahkan gambar ke Spreadsheet
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setPath(public_path('images/logo/absensi.png')); // Ganti dengan path gambar yang sesuai
        $drawing->setCoordinates('A5'); // Koordinat di mana gambar akan ditambahkan
        $drawing->setWorksheet($spreadsheet->getActiveSheet());

        $sheet2 = $spreadsheet->createSheet();
        $sheet2->setTitle('Data Alat Berat2');
        $sheet2->setCellValue('A1', 'Data 2');

        $sheet3 = $spreadsheet->createSheet();
        $sheet3->setTitle('Data Alat Berat3');
        $sheet3->setCellValue('A1', 'Data 3');

        $writer = new Xlsx($spreadsheet);
        $fileName = 'Data Alat Berat.xlsx';
        $writer->save($fileName);

        return response()->download($fileName);
    }

    public function exportExcel()
    {
        $alat = AlatBeratJenis::with('Alat')->orderBy('Nama', 'asc')->get();
        $spreadsheet = new Spreadsheet();

        //Sheet 1 Alat Berat
        $sheet1 = $spreadsheet->getActiveSheet();
        $sheet1->setTitle('DAFTAR ALAT BERAT');

        $html = view('Alat/Export/alatExport', ['data' => $alat])->render();
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Html();
        $spreadsheet = $reader->loadFromString($html);

        foreach ($alat as $alat) {
            $this->detailExportAlatBerat($alat, $spreadsheet);
        }
        // $this->detailExportAlatBerat($alat[2], $spreadsheet);

        $writer = new Xlsx($spreadsheet);
        $fileName = 'Data Alat Berat.xlsx';
        $writer->save($fileName);
        return response()->download($fileName);
    }

    private function detailExportAlatBerat($detailAlat, $spreadsheet)
    {


        $sheet2 = $spreadsheet->createSheet();
        $sheet2->setTitle($detailAlat->Nama);

        $sheet2->getStyle($sheet2->calculateWorksheetDimension())->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)->setWrapText(true);
        $sheet2->getStyle('A1:H1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)->setWrapText(true);
        $sheet2->getStyle('A2:H2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)->setWrapText(true);
        $sheet2->getStyle('A4:H5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)->setWrapText(true);
        $sheet2->getStyle('F4:H5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)->setWrapText(true);

        $sheet2->setCellValue('A1', 'DAFTAR ALAT BERAT ' . $detailAlat->Nama);
        $sheet2->mergeCells('A1:H1');
        $sheet2->setCellValue('A2', 'TPK SARIMUKTI');
        $sheet2->mergeCells('A2:H2');

        $sheet2->getStyle('A4:H5')->getFont()->setBold(true);

        $sheet2->getStyle('A4:H5')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet2->setCellValue('A4', 'Jenis Peralatan');
        $sheet2->mergeCells('A4:B4');
        $sheet2->setCellValue('A5', 'FOTO');
        $sheet2->getColumnDimension('A')->setWidth(30);
        $sheet2->getStyle('A5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet2->setCellValue('B5', 'NAMA');
        $sheet2->getColumnDimension('B')->setWidth(15);
        $sheet2->getStyle('B5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet2->setCellValue('C4', 'TAHUN PEROLEHAN');
        $sheet2->getColumnDimension('C')->setWidth(15);
        $sheet2->mergeCells('C4:C5');
        $sheet2->getStyle('C4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet2->setCellValue('D4', 'KONDISI');
        $sheet2->getColumnDimension('D')->setWidth(20);
        $sheet2->mergeCells('D4:D5');
        $sheet2->getStyle('D4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet2->setCellValue('E4', 'KETERANGAN');
        $sheet2->getColumnDimension('E')->setWidth(15);
        $sheet2->mergeCells('E4:E5');
        $sheet2->getStyle('E4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet2->getColumnDimension('F')->setWidth(15);
        $sheet2->getColumnDimension('G')->setWidth(15);
        $sheet2->getColumnDimension('H')->setWidth(15);
        $sheet2->setCellValue('F4', 'TERAKHIR UPDATE');
        $sheet2->mergeCells('F4:H4');
        $sheet2->getStyle('F4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet2->setCellValue('F5', 'KONDISI');
        $sheet2->getStyle('F5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet2->setCellValue('G5', 'FOTO');
        $sheet2->getStyle('G5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet2->setCellValue('H5', 'KETERANGAN');
        $sheet2->getStyle('H5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);


        $i = 6;
        foreach ($detailAlat->Alat as $alat) {
            $drawing = new Drawing();
            $drawing->setName('Logo');


            if (file_exists(public_path($alat->Foto)) && $alat->Foto != null) {
                $drawing->setPath(public_path($alat->Foto));
            } else {
                $drawing->setPath(public_path('images/defaultImage.png'));
            }

            $drawing->setCoordinates('A' . $i);
            $drawing->setOffsetX(5);
            $drawing->setOffsetY(5);
            $drawing->setWidth(200);

            $drawing->setWorksheet($sheet2);

            $imageWidth = $drawing->getWidth();
            $imageHeight = $drawing->getHeight();

            $sheet2->getStyle('A' . $i . ':H' . $i)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet2->getColumnDimensionByColumn($i)->setWidth($imageWidth / 12);
            $sheet2->getRowDimension($i)->setRowHeight($imageHeight / 1.2);

            $sheet2->setCellValue('B' . $i, $alat->NamaModel . ' Seri-' . $alat->NoSeri);
            $sheet2->getStyle('B' . $i)
                ->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)
                ->setWrapText(true);

            $sheet2->setCellValue('C' . $i, date('F Y', strtotime($alat->TahunPerolehan)));
            $sheet2->getStyle('C' . $i)
                ->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)
                ->setWrapText(true);

            $kondisi = DB::table('alat_kondisi_detail')->where('AlatUuid', $alat->AlatUuid)->pluck('KondisiId')->toArray();
            $kondisi = AlatKondisi::whereIn('KondisiId', $kondisi)->orderBy('Label', 'asc')->get();
            $kondisiAlat = "Tidak Ada Kondisi";
            if ($kondisi != null || $kondisi != []) {
                $kondisiAlat = "";
                foreach ($kondisi as $value) {
                    $kondisiAlat .= $value->Label . ', ';
                }
            }
            $sheet2->setCellValue('D' . $i, $kondisiAlat);
            $sheet2->getStyle('D' . $i)
                ->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)
                ->setWrapText(true);

            $keteranganAlat = "";
            if ($alat->Keterangan == 0) {
                $keteranganAlat = "Beroperasi";
            } elseif ($alat->Keterangan == 1) {
                $keteranganAlat = "Beroperasi segera dilakukan perbaikan";
            } elseif ($alat->Keterangan == 2) {
                $keteranganAlat = "Breakdown/dapat dilakukan perbaikan";
            } elseif ($alat->Keterangan == 3) {
                $keteranganAlat = "Breakdown/rusak berat";
            }

            $sheet2->setCellValue('E' . $i, $keteranganAlat);
            $sheet2->getStyle('E' . $i)
                ->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)
                ->setWrapText(true);

            $sheet2->setCellValue('F' . $i, date('d F Y H:i:s', strtotime($alat->LastUpdateKondisi)));
            $sheet2->getStyle('F' . $i)
                ->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)
                ->setWrapText(true);

            $sheet2->setCellValue('G' . $i, date('d F Y H:i:s', strtotime($alat->LastUpdateFoto)));
            $sheet2->getStyle('G' . $i)
                ->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)
                ->setWrapText(true);

            $sheet2->setCellValue('H' . $i, date('d F Y H:i:s', strtotime($alat->LastUpdateKeterangan)));
            $sheet2->getStyle('H' . $i)
                ->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)
                ->setWrapText(true);

            $i++;
        }
    }
}
