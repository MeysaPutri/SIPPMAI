<?php

namespace App\Http\Controllers;

use App\Kelompok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KelompokController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kelompok = DB::table('kelompoks')->paginate(10);
        return view("pages.kelompok.index",[
            "kelompok" => $kelompok
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.kelompok.create');
    }

    public function submit(Request $request)
    {
        DB::table('kelompoks')->insert([
            ['nama_kel' => $request->nama_kel,
             'id_periode' => $request->id_periode]
        ]);

        return redirect()->route('kelompok');
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
     * @param  \App\Kelompok  $kelompok
     * @return \Illuminate\Http\Response
     */
    public function show(Kelompok $kelompok)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Kelompok  $kelompok
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $kelompok = DB::table('kelompoks')->where('id_kel',$id)->first();
        return view('pages.kelompok.edit', [
            "kelompok"=> $kelompok
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Kelompok  $kelompok
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::table('kelompoks')->where('id_kel', $id)->update([
            'nama_kel' => $request->nama_kel,
            'id_periode' => $request->id_periode
        ]);

        return redirect()->route('kelompok');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Kelompok  $kelompok
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kelompok $kelompok)
    {
        //
    }
}
