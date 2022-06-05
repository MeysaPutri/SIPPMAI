<?php

namespace App\Http\Controllers;

use App\Dosen;
use App\User;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
        $dosen = DB::table('dosens')
            ->leftJoin('users', 'dosens.nip', '=', 'users.nip_nim')
            ->select('users.*', 'dosens.*')
            ->get();

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
        $this->validate($request,[
            'nip' =>'required|unique:dosens',
            'email' =>'required|unique:dosens',
        ]);

        DB::table('dosens')->insert([
            'nip' => $request->nip,
            'nama_dosen' => $request->nama_dosen,
            'no_hp' => $request->no_hp,
            'email' => $request->email
        ]);

        DB::table('users')->insert([ 
            'nip_nim' =>$request->nip,
            'id_role' =>2,
            'name'=>$request->nama_dosen,
            'password'=>Hash::make($request->password),
            'status_aktif'=>'aktif',
            'email' => $request->email

        ]);  

        return redirect()->route('dosen')->with('pesan', 'Data dosen PAI berhasil ditambah'); 
    }

    public function delete($id)
    {
        DB::table('users')->where('nip_nim',$id)->delete();
        DB::table('dosens')->where('nip',$id)->delete();
        DB::table('kelas')->where('nip',$id)->delete();

        return redirect()->route('dosen')->with('pesan', 'Data dosen PAI berhasil dihapus');
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
        $dosen = DB::table('dosens')
            ->leftJoin('users', 'dosens.nip', '=', 'users.nip_nim')
            ->where('nip',$id)
            ->select('dosens.*', 'users.*', 'dosens.email as emaildosen')
            ->first();
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
        DB::table('users')->where('nip_nim', $id)->update([  
            'nip_nim' =>$request->nip,
            'id_role' =>2,
            'name'=>$request->nama_dosen,
            'status_aktif'=>'aktif',
            'email' => $request->email
        ]); 

        DB::table('dosens')->where('nip', $id)->update([
            'nip' => $request->nip,
            'nama_dosen' => $request->nama_dosen,
            'no_hp' => $request->no_hp,
            'email' => $request->email
        ]);

        return redirect()->route('dosen')->with('pesan', 'Data dosen PAI berhasil diubah');
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
