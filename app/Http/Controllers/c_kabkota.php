<?php

namespace App\Http\Controllers;

use App\Models\m_kabkota;
use Illuminate\Http\Request;
use \Yajra\Datatables\Datatables;

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
        $nama_kantor = m_kabkota::all();                    
        if ($request->ajax()) {
            $kabkota = m_kabkota::all();
            return DataTables::of($kabkota)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    // $btn = '<a href=' . route('kabkota.edit', $row->id_kab_kota) . ' style="font-size:20px" class="text-warning mr-10"><i class="lni lni-pencil-alt"></i></a>';
                    // $btn .= '<a href=' . route('kabkota.destroy', $row->id_kab_kota) . ' style="font-size:20px" class="text-danger mr-10" onclick="notificationBeforeDelete(event, this)"><i class="lni lni-trash-can"></i></a>';
                    // return $btn;
                })
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
        // $kabkota = m_kabkota::find($id);
        // if (!$kabkota) return redirect()->route('kabkota.index')
        //     ->with('error_message', 'kabkota dengan id'.$id.' tidak ditemukan');
        // return view('kabkota.edit', [
        //     'kabkota' => $kabkota
        // ]);
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
