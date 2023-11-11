<?php

namespace App\Http\Controllers;

use App\Models\AlatBeratJenis;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Symfony\Component\VarDumper\Cloner\Data;
use Yajra\DataTables\DataTables;

class AlatBeratJenisContoller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $jenis_alat = AlatBeratJenis::all();
            return DataTables::of($jenis_alat)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $newdata = json_decode($row);
                    foreach ($newdata as $key => $value) {
                        $newdata->$key = str_replace(" ", "-", $value);
                    }
                    $newdata = json_encode($newdata);

                    $btn = '<a href=' . route('jenisalat.update', $row->JenisAlatBeratId) . ' data-id=' . $newdata . ' style="font-size:20px" class="text-warning mr-10" onClick="notificationEdit(event,this)"><i class="lni lni-pencil-alt"></i></a>';
                    $btn .= '<a href=' . route('jenisalat.destroy', $row->JenisAlatBeratId) . ' style="font-size:20px" class="text-danger mr-10" onClick="notificationBeforeDelete(event,this)"><i class="lni lni-trash-can"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('AlatBeratJenis.index');
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
        $data = [
            'Kode' => $request->Kode,
            'Nama' => $request->Nama
        ];

        AlatBeratJenis::create($data);
        Alert::success('Success', 'Berhasil menambahkan data jenis alat berat');
        return redirect()->route('jenisalat.index');
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
            'Kode' => $request->Kode,
            'Nama' => $request->Nama
        ];

        AlatBeratJenis::where('JenisAlatBeratId', $request->JenisAlatBeratId)->update($data);
        Alert::success('Success', 'Berhasil mengupdate data jenis alat berat');
        return redirect()->route('jenisalat.index');
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
            AlatBeratJenis::where('JenisAlatBeratId', $id)->delete();
            Alert::success('Success', 'Berhasil menghapus data jenis alat berat');
            return redirect()->route('jenisalat.index');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1451) {
                Alert::error('Error', 'Gagal menghapus data Jenis, karena data masih digunakan');
                return redirect()->route('jenisalat.index');
            } else {
                Alert::error('Error', 'Terjadi Keasalahan ' . $e->getMessage());
                return redirect()->route('jenisalat.index');
            }
        }
    }
}
