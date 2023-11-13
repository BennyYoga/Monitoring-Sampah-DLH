<?php

namespace App\Http\Controllers;

use App\Models\AsetPembelian;
use Illuminate\Http\Request;
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
        $aset_jenis = AsetPembelian::get();
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
                    return $row->DetailBarang->sum('Harga');
                })
                ->addColumn('TotalPembelian', function($row){
                    return $row->DetailBarang->count();
                })
                ->addColumn('action', function($row){
                    $btn = '<a href="" style="font-size:20px" class="text-warning mr-10" onClick="notificationEdit(event,this)"><i class="lni lni-pencil-alt"></i></a>';
                    $btn .= '<a href=""   style="font-size:20px" class="text-danger mr-10" onClick="notificationBeforeDelete(event,this)"><i class="lni lni-trash-can"></i></a>';
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
