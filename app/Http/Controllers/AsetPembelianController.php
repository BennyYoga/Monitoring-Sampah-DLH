<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\AsetBarang;
use App\Models\AsetPembelian;
use App\Models\AsetPembelianDetail;
use Faker\Provider\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class AsetPembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request  $request)
    {
        //
        $aset_jenis = AsetPembelian::all();
        // $nama_barang = $aset_jenis->Barang->Nama;
        // dd($aset_jenis->detailBarang->Barang->Nama);
        if ($request->ajax()) {
            return DataTables::of($aset_jenis)
                ->addIndexColumn()
                ->addColumn('Tanggal', function ($row) {
                    return date('d F Y', strtotime($row->Tanggal));
                })
                ->addColumn('JumlahUnit', function ($row) {
                    return $row->DetailBarang->sum('Unit');
                })
                ->addColumn('TotalHarga', function ($row) {
                    $totalHarga =  $row->DetailBarang->sum('Harga');
                    return 'Rp. ' . number_format($totalHarga, 0, ',', '.');
                })
                ->addColumn('TotalPembelian', function($row){
                    return $row->DetailBarang->count();
                })
                ->addColumn('action', function($row){
                    $i = 0;
                    foreach($row->detailBarang as $item){
                        $row->detailBarang[$i] = [
                            'NamaBarang' => $item->Barang->Nama,
                            'Unit' => $item->Unit,
                            'Harga' => $item->Harga,
                            'TotalHarga' => $item->Unit * $item->Harga,
                        ];
                        $i++;
                    }
                    $btn = '<a href=""  data-id=\'' . $row . '\' style="font-size:20px" class="text-primary mr-10" onClick="notificationDetailPembelian(event,this)"><i class="lni lni-eye"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('AsetPembelian.index');
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
        return view('AsetPembelian.form', compact('barang'));
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
        $BeliUuid = Uuid::uuid();
        if(!$request->Barang){
            Alert::error('Gagal', 'Tidak ada barang yang dipilih');
            return redirect()->route('aset.pembelian.create');
        }
        if(count($request->Barang) != count($request->Unit) || count($request->Barang) != count($request->Harga)){
            Alert::error('Gagal', 'Terdapat Row Yang tidak diisi');
            return redirect()->route('aset.pembelian.create');
        }
        for ($i=0; $i < count($request->Barang); $i++) { 
            # code...
        }
        
        $dataBeli = [
            'BeliUuid' => $BeliUuid,
            'Tanggal' => $request->tanggalPembelian,
        ];
        AsetPembelian::create($dataBeli);

        $listBarang = $request->all();
        for($i=0; $i<count($listBarang['Barang']); $i++){
            $data = [
                'BeliUuid' => $BeliUuid,
                'BarangUuid' => $listBarang['Barang'][$i],
                'Unit' => $listBarang['Unit'][$i],
                'Harga' => $listBarang['Harga'][$i],
            ];
            AsetBarang::where('BarangUuid', $listBarang['Barang'][$i])->increment('TotalUnit', $listBarang['Unit'][$i]);
            AsetPembelianDetail::create($data);
        }

        Alert::success('Berhasil', 'Data Berhasil Ditambahkan');
        return redirect()->route('aset.pembelian.index');
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
