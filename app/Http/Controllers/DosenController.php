<?php

namespace App\Http\Controllers;

use App\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DosenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //method untuk show data
    public function index()
    {
        $dosen = DB::table('dosens')->paginate(10);
        return view("pages.dosen.index",[
            "dosen" => $dosen
        ]);
    }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    //method untuk tambah data
    public function create()
    {
       return view("pages.dosen.create");
    }

    //method untuk simpan data
    public function submit(Request $request)
    { 
        DB::table('dosens')->insert([
            ['nip_nim' => $request->nip_nim,
             'nama_dosen' => $request->nama_dosen,
             'no_hp' => $request->no_hp,
             'email' => $request->email]
        ]);

        return redirect()->route('dosen'); 
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
     * @param  \App\Dosen  $dosen
     * @return \Illuminate\Http\Response
     */
    public function show(Dosen $dosen)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Dosen  $dosen
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dosen = DB::table('dosens')->where('id_dosen',$id)->first();
        return view('pages.dosen.edit', [
            "dosen"=> $dosen
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Dosen  $dosen
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::table('dosens')->where('id_dosen', $id)->update([
            'nip_nim' => $request->nip_nim,
            'nama_dosen' => $request->nama_dosen,
            'no_hp' => $request->no_hp,
            'email' => $request->email
        ]);

        return redirect()->route('dosen');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Dosen  $dosen
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dosen $dosen)
    {
        //
    }
}
