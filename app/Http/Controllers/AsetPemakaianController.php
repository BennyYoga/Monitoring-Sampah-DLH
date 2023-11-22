<?php

namespace App\Http\Controllers;

use App\Models\AsetBarang;
use App\Models\AsetPemakaian;
use App\Models\AsetPemakaianDetail;
use Faker\Provider\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class AsetPemakaianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request  $request)
    {
        //
        $aset_jenis = AsetPemakaian::all();
        // $nama_barang = $aset_jenis[1]->DetailBarang[0]->Barang->Alat;
        // dd($nama_barang);
        if ($request->ajax()) {
            return DataTables::of($aset_jenis)
                ->addIndexColumn()
                ->addColumn('Tanggal', function ($row) {
                    return date('d F Y', strtotime($row->Tanggal));
                })
                ->addColumn('JumlahUnit', function ($row) {
                    return $row->DetailBarang->sum('Unit');
                })
                ->addColumn('TotalBarang', function($row){
                    return $row->DetailBarang->count();
                })
                ->addColumn('action', function($row){
                    $i = 0;
                    foreach($row->detailBarang as $item){
                        $row->detailBarang[$i] = [
                            'NamaBarang' => $item->Barang->Nama,
                            'Merk' => $item->Barang->Alat->Merk ?? null,
                            'Model' => $item->Barang->Alat->NamaModel ?? null,
                            'Unit' => $item->Unit,
                        ];
                        $i++;
                    }
                    $btn = '<a href=""  data-id=\'' . $row . '\' style="font-size:20px" class="text-primary mr-10" onClick="notificationDetailPemakaian(event,this)"><i class="lni lni-eye"></i></a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('AsetPemakaian.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $barang = AsetBarang::get();
        return view('AsetPemakaian.form', compact('barang'));
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
        $PakaiUuid = Uuid::uuid();
        if(!$request->Barang){
            Alert::error('Gagal', 'Tidak ada barang yang dipilih');
            return redirect()->route('aset.pemakaian.create');
        }
        if(count($request->Barang) != count($request->Unit)){
            Alert::error('Gagal', 'Terdapat Row Yang tidak diisi');
            return redirect()->route('aset.pemakaian.create');
        }
        foreach ($request->Barang as $key => $value) {
            if($value == '-'){
                Alert::error('Gagal', 'Terdapat Row Yang tidak diisi');
                return redirect()->route('aset.pemakaian.create');
            }
        }
        
        //Pengecekan Stok
        foreach ($request->Barang as $key => $value) {
            $stok = AsetBarang::where('BarangUuid', $value)->first();
            if($stok->TotalUnit < $request->Unit[$key]){
                Alert::error('Gagal', 'Stok Barang ' . $stok->Nama . ' Tidak Mencukupi');
                return redirect()->route('aset.pemakaian.create');
            }
        }
        
        $dataPakai = [
            'PakaiUuid' => $PakaiUuid,
            'Tanggal' => $request->tanggalPemakaian,
        ];
        AsetPemakaian::create($dataPakai);

        $listBarang = $request->all();
        for($i=0; $i<count($listBarang['Barang']); $i++){
            $data = [
                'PakaiUuid' => $PakaiUuid,
                'BarangUuid' => $listBarang['Barang'][$i],
                'Unit' => $listBarang['Unit'][$i],
            ];
            AsetBarang::where('BarangUuid', $listBarang['Barang'][$i])->decrement('TotalUnit', $listBarang['Unit'][$i]);
            AsetPemakaianDetail::create($data);
        }

        Alert::success('Berhasil', 'Data Berhasil Ditambahkan');
        return redirect()->route('aset.pemakaian.index');
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
}
