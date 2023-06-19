<?php

namespace App\Http\Controllers;

use App\Models\Kantor;
use App\Models\Pegawai;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class PegawaiController extends Controller
{
    //
    public function index(Request $request)
    {
        $nama_kantor = Kantor::query();                    
        if ($request->ajax()) {
            $pegawai = Pegawai::query();
            return DataTables::of($pegawai)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    // $btn = '<a href=' . route('warga.show', $row->NIK) . ' style="font-size:20px" class="text-primary mr-10"><i class="lni lni-eye"></i></a>';
                    // $btn .= '<a href=' . route('warga.edit', $row->NIK) . ' style="font-size:20px" class="text-warning mr-10"><i class="lni lni-pencil-alt"></i></a>';

                    return ;
                })
                ->addColumn('nama_kantor', function ($row) {
                    $kantor = Kantor::where('id_kantor', $row->id_kantor)->first();                    
                    return $kantor->nama_kantor;
                })
                ->addColumn('nama_role', function ($row) {
                    $role = Role::where('id_role', $row->id_role)->first();
                    return $role->nama_role;
                })
                ->make(true);
        }

        return view('Pegawai.index');
    }
}
