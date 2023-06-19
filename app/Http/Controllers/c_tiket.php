<?php

namespace App\Http\Controllers;

use App\Models\m_kabkota;
use App\Models\m_tiket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use mysqli;
use DateTime;

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
        // $join = m_tiket::where('id_kab_kota', $kabkota->id_kab_kota)->first();
        return view('tiket.index', compact('tiket'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kabkota=m_kabkota::All();
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
                'pengemudi' =>'required',
                'lokasi_sampah' =>'required',
                'volume' =>'required',
                'id_kab_kota' => 'required',
            ]
            );
            $data= $request->all();
            $data['id_kab_kota'] = (int)$data['id_kab_kota'];
            
            $waktu = new DateTime();
            $data['jam_masuk'] = $waktu;
            m_tiket::create($data);
            return redirect()-> route('tiket.index')->with('succes_message', 'Berhasil Menambahkan Tiket');

        
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
        $tiket = m_tiket::find($id);
        if (!$tiket) return redirect()->route('tiket.index')
            ->with('error_message', 'tiket dengan id'.$id.' tidak ditemukan');
        return view('tiket.edit', compact('tiket'));
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

        $request->validate(
            [
                'no_kendaraan' =>'required',
                'jenis_kendaraan' =>'required',
                'pengemudi' =>'required',
                'lokasi_sampah' =>'required',
                'volume' =>'required',
            ]
            );
            $data= [
                'no_kendaraan' => $request->input('no_kendaraan'),
                'jenis_kendaraan' =>$request->input('jenis_kendaraan'),
                'pengemudi'=>$request->input('pengemudi'),
                'lokasi_sampah' => $request->input('lokasi_sampah'),
                'volume' => $request->input('volume'),
            ];
        m_tiket::where('id', $id )->update($data);

        return redirect()->route('tiket.index', ['id'=>$id])->with('message', 'Berhasil Memperbarui tiket');

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
