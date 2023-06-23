<?php

namespace App\Http\Controllers;

use App\Models\Kantor;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Mpdf\Mpdf as PDF;

class KantorController extends Controller
{
    public function index(Request $request){
        if ($request->ajax()) {
            $kantor = Kantor::all();
            return DataTables::of($kantor)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href=' . route('kantor.edit', $row->id_kantor) . ' style="font-size:20px" class="text-warning mr-10"><i class="lni lni-pencil-alt"></i></a>';
                    $btn .= '<a href=' . route('kantor.destroy', $row->id_kantor) . ' style="font-size:20px" class="text-danger mr-10" onclick="notificationBeforeDelete(event, this)"><i class="lni lni-trash-can"></i></a>';
                    return $btn;
                })
                ->make(true);
            }
        return view('Kantor.index');
    }

    public function create()
    {
        $kantor = Kantor::all();
        return view('Kantor.form', compact('kantor'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kantor' => 'required',
            'alamat_kantor' => 'required'
        ]);

        $data = $request->all();
        Kantor::create($data);

        return redirect()->route('kantor')->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kantor  $kantor
     * @return \Illuminate\Http\Response
     */
    public function show(Kantor $kantor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id_kantor
     * @return \Illuminate\Http\Response
     */
    public function edit($id_kantor)
    {
        $kantor = Kantor::find($id_kantor);
    if (!$kantor) return redirect()->route('pegawai')
        ->with('error_message', 'Anggota dengan NIP'.$id_kantor.' tidak ada');
    return view('Kantor.edit', compact('kantor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id_kantor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_kantor)
    {
        $request->validate([
            'nama_kantor' => 'required',
            'alamat_kantor' => 'required'
        ]);

        $data = $request->all();
        Kantor::find($id_kantor)->update($data);

        return redirect()->route('kantor')->with('success', 'Data berhasil diubah');
    }

    public function destroy($id_kantor)
    {
        $kantor = Kantor::find($id_kantor);
        $kantor->delete();
            return redirect()->route('kantor')->with('success', 'Berhasil menghapus kantor');
    }
    
    public function document (){
        $kantor = Kantor::all();
        $mpdf = new PDF(['orientation' => 'L']);
        // $html ="";
        $html = view('Kantor.print',compact('kantor'));
        // $html=$html->render();
        $mpdf ->writeHTML($html);
        $mpdf -> Output("Daftar kantor.pdf","I");
    }
}
