<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\AlatBeratJenis;
use App\Models\AlatKondisi;
use DateTime;
use Faker\Provider\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
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
                ->addColumn('action', function ($row) {
                    $newdata = json_decode($row);
                    foreach ($newdata as $key => $value) {
                        $newdata->$key = str_replace(" ", "_", $value);
                    }
                    $newdata = json_encode($newdata);
                    
                    $btn = '<a href='. route('alat.show', $row->AlatUuid) .'  data-id='. $newdata .' style="font-size:20px" class="text-primary mr-10" onClick="notificationDetailAlat(event,this)"><i class="lni lni-eye"></i></a>';
                    $btn .= '<a href=' . route('alat.edit', $row->AlatUuid) . '  style="font-size:20px" class="text-warning mr-10"><i class="lni lni-pencil-alt"></i></a>';
                    $btn .= '<a href=' . route('alat.destroy', $row->AlatUuid) . ' style="font-size:20px" class="text-danger mr-10" onClick="notificationBeforeDelete(event,this)"><i class="lni lni-trash-can"></i></a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('alat.index');
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
            if(in_array($value->KondisiId, $konsiDetailList)){
                $isiData = [
                    'KondisiId' => $value->KondisiId,
                    'Label' => $value->Label,
                    'selected' => true,
                ];
                array_push($dataKondisi, $isiData);
            }
            else{
                $isiData = [
                    'KondisiId' => $value->KondisiId,
                    'Label' => $value->Label,
                    'selected' => false,
                ];
                array_push($dataKondisi, $isiData);
            }
        };
        $jenis_alat_berat = AlatBeratJenis::all();
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
        if($alatBefore->Keterangan != (int)$request->Keterangan){
            $keteranganUpdate = date('Y-m-d H:i:s');
        }
        else{
            $keteranganUpdate = $alatBefore->LastUpdateKeterangan;
        }
        
        //Pengecekan Perubahan Kondisi
        $kondisiBefore = DB::table('alat_kondisi_detail')->where('AlatUuid', $id)->pluck('KondisiId')->toArray();
        if($kondisiBefore != $request->Kondisi){
            $kondisiUpdate = date('Y-m-d H:i:s');
        }
        else{
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
        if($alatBefore->TahunPerolehan != $request->TahunPerolehan){
            $tahunPerolehan = $request->TahunPerolehan . '-01';
        }
        else{
            $tahunPerolehan = $alatBefore->TahunPerolehan;
        }

        $data = [
            'Kode' => $alatBefore->Kode,
            'JenisAlatBerat' => (int) $request->JenisAlatBeratId,
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
        $path = Alat::where('AlatUuid', $id)->first()->Foto;
        if (file_exists(public_path($path))) {
            unlink(public_path($path));
        }
        DB::table('alat_kondisi_detail')->where('AlatUuid', $id)->delete();
        Alat::where('AlatUuid', $id)->delete();
        Alert::success('Success', 'Berhasil menghapus data alat');
        return redirect()->route('alat.index');
    }

    public function uploadImage(Request $request)
    {
        $image = $request->file('file');
        $imageName = time() . '.' . $image->extension();
        $image->move(public_path('images/temp/'), $imageName);

        return response()->json(['success' => $imageName]);
    }
}
