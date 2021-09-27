<?php

namespace App\Http\Controllers;

use App\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kelas = DB::table('kelas')->paginate(10);
        return view("pages.kelas.index",[
            "kelas" => $kelas
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.kelas.create');
    }

    public function submit(Request $request)
    {
        DB::table('kelas')->insert([
            ['nama_kelas' => $request->nama_kelas,
             'id_dosen' => $request->id_dosen]
        ]);

        return redirect()->route('kelas'); 
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
     * @param  \App\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function show(Kelas $kelas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $kelas = DB::table('kelas')->where('id_kelas',$id)->first();
        return view('pages.kelas.edit', [
            "kelas"=> $kelas
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::table('kelas')->where('id_kelas', $id)->update([
            'nama_kelas' => $request->nama_kelas,
            'id_dosen' => $request->id_dosen
        ]);

        return redirect()->route('kelas');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kelas $kelas)
    {
        //
    }
}
