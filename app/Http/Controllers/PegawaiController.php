<?php

namespace App\Http\Controllers;

use App\Models\Kantor;
use App\Models\Pegawai;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Hash;
use Mpdf\Mpdf as PDF;

class PegawaiController extends Controller
{
    //
    public function index(Request $request)
    {
        $nama_kantor = Kantor::all();                    
        if ($request->ajax()) {
            $pegawai = Pegawai::all();
            return DataTables::of($pegawai)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href=' . route('pegawai.edit', $row->id_pegawai) . ' style="font-size:20px" class="text-warning mr-10"><i class="lni lni-pencil-alt"></i></a>';
                    $btn .= '<a href=' . route('pegawai.destroy', $row->id_pegawai) . ' style="font-size:20px" class="text-danger mr-10" onclick="notificationBeforeDelete(event, this)"><i class="lni lni-trash-can"></i></a>';
                    return $btn;
                })
                ->addColumn('nama_kantor', function ($row) {
                    $kantor = Kantor::where('id_kantor', $row->id_kantor)->first();                    
                    return $kantor->nama_kantor;
                })
                ->addColumn('nama_role', function ($row) {
                    $role = Role::where('id_role', $row->id_role)->first();
                    return $role->nama_role;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('Pegawai.index');
    }

    public function create()
    {
        $pegawai = Pegawai::all();
        $kantor = Kantor::all();
        return view('Pegawai.form', compact('pegawai', 'kantor'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_kantor' => 'required',
            'nama_pegawai' => 'required',
            'NIP' => 'required',
            'password' => 'required'
        ]);

        $data = $request->all();
        $data['id_role'] = 2;
        $data['password'] = Hash::make($request->password);
        Pegawai::create($data);

        return redirect()->route('pegawai')->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id_pegawai
     * @return \Illuminate\Http\Response
     */
    public function edit($id_pegawai)
    {
        $kantor = Kantor::all();
        $pegawai = Pegawai::find($id_pegawai);
    if (!$pegawai) return redirect()->route('pegawai')
        ->with('error_message', 'Anggota dengan ID'.$id_pegawai.' tidak ada');
    return view('Pegawai.edit', compact('pegawai', 'kantor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id_pegawai
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_pegawai)
    {
        $request->validate([
            'id_kantor' => 'required',
            'nama_pegawai' => 'required',
            'NIP' => 'required',
            'password' => 'required'
        ]);

        $data = $request->all();
        $data['id_role'] = 2;
        $data['password'] = Hash::make($request->password);
        Pegawai::find($id_pegawai)->update($data);

        return redirect()->route('pegawai')->with('success', 'Data berhasil diubah');
    }

    public function destroy($id_pegawai)
    {
        $pegawai = Pegawai::find($id_pegawai);
        if ($pegawai) {
            $pegawai->delete();
            return redirect()->route('pegawai')->with('success', 'Berhasil menghapus pegawai');
        }
        return redirect()->route('pegawai')->with('error', 'Pegawai tidak ditemukan');
    }

    public function document (){
        $pegawai = Pegawai::all();
        $mpdf = new PDF(['orientation' => 'L']);
        // $html ="";
        $html = view('Pegawai.print',compact('pegawai'));
        // $html=$html->render();
        $mpdf ->writeHTML($html);
        $mpdf -> Output("Daftar Pegawai.pdf","I");
    }
}
