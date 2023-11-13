<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\AsetBarang;
use App\Models\AsetJenis;
use Faker\Provider\Uuid;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class AsetBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if ($request->ajax()) {
            $barang = AsetBarang::all();
            return DataTables::of($barang)
                ->addIndexColumn()
                ->addColumn('Jenis', function ($row) {
                    return $row->AsetJenis->Nama;
                })
                ->addColumn('Bahan', function ($row) {
                    $bahan = $row->AsetJenis->Bahan;
                    $keterangan = '';
                    switch ($bahan) {
                        case 0:
                            $keterangan = 'BAHAN BANGUNAN DAN KONSTRUKSI';
                            break;
                        case 1:
                            $keterangan = 'BAHAN KIMIA';
                            break;
                        case 2:
                            $keterangan = 'ALAT/BAHAN UNTUK KEGIATAN KANTOR';
                            break;
                        case 3:
                            $keterangan = 'SUKU CADANG';
                            break;
                        default:
                            $keterangan = 'TIDAK TERMASUK KATEGORI';
                            break;
                    }
                    return $keterangan;
                })
                ->addColumn('action', function ($row) {

                    $btn = '<a href=' . route('aset.jenis.update', $row->Id) . ' data-id=\'' . $row . '\'  style="font-size:20px" class="text-warning mr-10" onClick="notificationEdit(event,this)"><i class="lni lni-pencil-alt"></i></a>';
                    $btn .= '<a href=' . route('aset.barang.destroy', $row->BarangUuid) . ' style="font-size:20px" class="text-danger mr-10" onClick="notificationBeforeDelete(event,this)"><i class="lni lni-trash-can"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $jenisBarang = AsetJenis::all();
        $alat = Alat::all();
        return view('AsetBarang.index', compact('jenisBarang', 'alat'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $bahan = json_decode($request->JenisBahan);
        $AlatBeratId = null;
        if ($request->AlatBerat) {
            $AlatBeratId = $request->AlatBerat;
            $data = [
                'BarangUuid' => Uuid::uuid(),
                'JenisId' => $bahan->Id,
                'AlatBeratId' => $AlatBeratId,
                'Nama' => $request->NamaBarang,
                'TotalUnit' => 0,
                'Satuan' => $request->SatuanBarang,
            ];
        } else {
            $data = [
                'BarangUuid' => Uuid::uuid(),
                'AlatBeratId' => $AlatBeratId,
                'JenisId' => $bahan->Id,
                'Nama' => $request->NamaBarang,
                'TotalUnit' => 0,
                'Satuan' => $request->SatuanBarang,
            ];
        }
        AsetBarang::create($data);
        Alert::success('Success', 'Data berhasil ditambahkan');
        return redirect()->route('aset.barang.index');
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
    public function update(Request $request)
    {
        //
        $bahan = json_decode($request->JenisBahan);
        $AlatBeratId = null;
        if ($request->AlatBerat && $bahan->Bahan == 3) {
            $AlatBeratId = $request->AlatBerat;
            $data = [
                'BarangUuid' => $request->BarangUuid,
                'JenisId' => $bahan->Id,
                'AlatBeratId' => $AlatBeratId,
                'Nama' => $request->NamaBarang,
                'Satuan' => $request->SatuanBarang,
            ];
        } else {
            $data = [
                'BarangUuid' => $request->BarangUuid,
                'AlatBeratId' => $AlatBeratId,
                'JenisId' => $bahan->Id,
                'Nama' => $request->NamaBarang,
                'Satuan' => $request->SatuanBarang,
            ];
        }
        
        AsetBarang::where('BarangUuid', $request->BarangUuid)->update($data);
        Alert::success('Success', 'Data berhasil diubah');
        return redirect()->route('aset.barang.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        AsetBarang::where('BarangUuid', $id)->delete();
        Alert::success('Success', 'Data berhasil dihapus');
        return redirect()->route('aset.barang.index');
    }
}
