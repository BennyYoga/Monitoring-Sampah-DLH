<?php

namespace App\Http\Controllers;

use App\Models\AsetJenis;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class AsetJenisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request  $request)
    {
        //
        if ($request->ajax()) {
            $aset_jenis = AsetJenis::all();
            return DataTables::of($aset_jenis)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href=' . route('aset.jenis.update', $row->Id) . ' data-id=\'' . $row . '\' style="font-size:20px" class="text-warning mr-10" onClick="notificationEdit(event,this)"><i class="lni lni-pencil-alt"></i></a>';
                    $btn .= '<a href= '. route('aset.jenis.destroy', $row->Id) .'  style="font-size:20px" class="text-danger mr-10" onClick="notificationBeforeDelete(event,this)"><i class="lni lni-trash-can"></i></a>';
                    return $btn;
                })
                ->addColumn('Bahan', function ($row) {
                    $keterangan = '';
                    switch ($row->Bahan) {
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
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('AsetJenis.index');
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
        if ($request->Bahan == null) {
            Alert::error('Gagal', 'Field Bahan Tidak Boleh Kosong');
        } else {
            AsetJenis::create([
                'Bahan' => $request->Bahan,
                'Nama' => $request->Nama_Jenis
            ]);
            Alert::success('Berhasil', 'Data Jenis Aset Berhasil Ditambahkan');
        }
        return redirect()->route('aset.jenis.index');
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
        $data = [
            'Nama' => $request->Nama_Jenis,
            'Bahan' => $request->Bahan
        ];
        AsetJenis::where('Id', $request->Id)->update($data);
        Alert::success('Success', 'Berhasil mengubah data Jenis Aset');
        return redirect()->route('aset.jenis.index');
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
        AsetJenis::where('Id', $id)->delete();
        Alert::success('Success', 'Berhasil menghapus data Jenis Aset');
        return redirect()->route('aset.jenis.index');
    }
}
