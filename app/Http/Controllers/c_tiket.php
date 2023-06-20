<?php

namespace App\Http\Controllers;

use App\Models\m_kabkota;
use App\Models\m_tiket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use \Yajra\Datatables\Datatables;
use mysqli;

class c_tiket extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $tiket = m_tiket::query();
            return DataTables::of($tiket)
                ->addColumn('nama_kab_kota', function ($row) {
                    $kab_kota = m_kabkota::where('id_kab_kota', $row->id_kab_kota)->first();                    
                    return $kab_kota->nama_kab_kota;
                })
                    ->addColumn('action', function ($row) {
                        // Tambahkan aksi yang diperlukan di sini
                        // Contoh: edit, hapus, dll.
                        // return '<a href="#" class="btn btn-primary">Edit</a>';
                        $tiket = m_tiket::all();
                        $btn = '';
                
                            if ($row->jam_keluar === null) {
                                $btn .= '<a href="' . route('tiket.edit', $row->id) . '" class="btn btn-primary">Selesai</a>';
                            } else {
                                $btn .= '';
                            }
                        
                        return $btn;

                })
                ->rawColumns(['action'])
                ->make(true);
        }
    
        return view('tiket.index');
    
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kabkota=m_kabkota::All();
        return view('tiket.form', compact('kabkota'));
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
                $data['jam_masuk'] = date("d-m-Y H:i:s", now()->timestamp);
                // dd($data)
                // $data['jam_masuk'] = strtotime($data['jam_masuk']);
                // $dateTime = m_tiket::createFromFormat("d-m-Y H:i:s", $data['jam_masuk']);
                // $timestamp = $dateTime->getTimestamp();
                // $data['jam_masuk']= $timestamp;
                // dd($data);
                // dd($data['id_kab_kota']);;
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
