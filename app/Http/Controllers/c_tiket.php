<?php

namespace App\Http\Controllers;

use App\Models\m_kabkota;
use App\Models\m_tiket;
use Illuminate\Http\Request;
use mysqli;

class c_tiket extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tiket = m_tiket::All();
        $kabkota=m_kabkota::All();
        return view('tiket.index', compact('tiket', 'kabkota'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tiket.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request -> validate(
            [
                'no_kendaraan' =>'required',
                'jenis_kendaraan' =>'required',
                'pengemudi ' =>'required',
                'lokasi_sampah' =>'required',
                'volume' =>'required',
            ]
            );
            $data= $request->only(
                [
                    'no_kendaraan', 'jenis_kendaraan', 'pengemudi', 'lokasi_sampah', 'volume',
                ]);
                $tiket = m_tiket::create($data);

            return redirect()-> route('tiket')->with('succes_message', 'Berhasil Menambahk Tiket');

        
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
