<?php

namespace App\Http\Controllers;

use App\Models\m_kabkota;
use App\Models\m_tiket;
use Illuminate\Http\Request;
use \Yajra\Datatables\Datatables;
use Mpdf\Mpdf as PDF;

class c_kabkota extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $kabkota = m_kabkota::All();
        // return view('kabkota.index', compact('kabkota'));
        if ($request->ajax()) {
            $kabkota = m_kabkota::all();
            return DataTables::of($kabkota)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href=' . route('kabkota.edit', $row->id_kab_kota) . ' style="font-size:20px" class="text-warning mr-10"><i class="lni lni-pencil-alt"></i></a>';
                    $btn .= '<a href=' . route('kabkota.destroy', $row->id_kab_kota) . ' style="font-size:20px" class="text-danger mr-10" data-bs-toggle="modal" data-bs-target="#staticBackdrop" id="hapusBtn"><i class="lni lni-trash-can"></i></a>';
                    return $btn;
                })
                    
                    // $btn = '<a href=' . route('kabkota.edit', $row->id_kab_kota) . ' style="font-size:20px" class="text-warning mr-10"><i class="lni lni-pencil-alt"></i></a>';
                    // $btn .= '<a href=' . route('kabkota.destroy', $row->id_kab_kota) . ' style="font-size:20px" class="text-danger mr-10" onclick="notificationBeforeDelete(event, this)"><i class="lni lni-trash-can"></i></a>';
                    // return $btn;
                ->make(true);
        }

        return view('kabkota.index');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('kabkota.form');
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
                'nama_kab_kota' =>'required',
            ]
            );
            $data= $request->all();
            // dd($data);
            $check= m_kabkota::where('nama_kab_kota', $data['nama_kab_kota'])->first();

            if(!$check){
                m_kabkota::create($data);
                return redirect()-> route('kabkota.index')->withToastSuccess('Berhasil Menambahkan Kota / Kabupaten');
            }else{
                return redirect()->route('kabkota.index')->withToastError('Nama Kota Sudah Ada');
            }

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
    public function edit($id_kab_kota)
    {
        $kabkota = m_kabkota::find($id_kab_kota);
        if (!$kabkota) return redirect()->route('kabkota.index')
            ->with('error_message', 'kabkota dengan id'.$id_kab_kota.' tidak ditemukan');
        return view('kabkota.edit', compact('kabkota'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_kab_kota)
    {
        $request->validate([
            'nama_kab_kota' => 'required',
        ]);
        $data=$request->all();
        $check= m_kabkota::where('nama_kab_kota', $data['nama_kab_kota'])->first();

        if(!$check){
            m_kabkota::find($id_kab_kota)->update($data);
            return redirect()-> route('kabkota.index')->withToastSuccess('Berhasil Mememperbaharui Data');
        }else{
            return redirect()->route('kabkota.index')->withToastError('Gagal memperbaharui Data');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_kab_kota)
    {
        $kabkota = m_kabkota::find($id_kab_kota);
        $kabkota->delete();
        return redirect()->route('kabkota.index')->with('success', 'Kabupaten / Kota Berhasil Dihapus');

//            return redirect()->route('kabkota.index')->withToastSuccess('Berhasil menghapus Data');
    }

    public function document (){
        $kabkota = m_kabkota::all();
        $mpdf = new PDF(['orientation' => 'P']);
        $html = view('kabkota.print',compact('kabkota'));
        $mpdf ->writeHTML($html);
        $mpdf -> Output("Daftar KabupatenKota.pdf","D");
    }
}
