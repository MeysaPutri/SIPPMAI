<?php

namespace App\Http\Controllers;

use App\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use File;

class PeriodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $periode =  DB::table('periodes')->paginate(10);
        return view('pages.periode.index',[
            "periode" => $periode
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.periode.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     public function submit(Request $request)
     {
        $request->validate([
            'materi' => 'mimes:pdf,docx,ppt,txt',
            'periode' =>'required'
        ]);

        $materiName=null;

        if($request->materi){
            $materiName=$request->materi->getClientOriginalName(). '-' . time() . '.'
            .$request->materi->extension();
            $request->materi->move(public_path('materi'), $materiName);
        }

        DB::table('periodes')->insert([
            'periode' => $request->periode,
            'materi' => $materiName
        ]);

        return redirect()->route('periode')->with('pesan', 'Periode berhasil ditambah'); 
     }

    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Periode  $periode
     * @return \Illuminate\Http\Response
     */
    public function show(Periode $periode)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Periode  $periode
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $periode = DB::table('periodes')->where('id_periode',$id)->first();
        return view('pages.periode.edit', [
            "periode"=> $periode
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Periode  $periode
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'materi' => 'mimes:pdf,txt,docx,ppt',
            'periode' => 'required',
        ]);

        $materiName = $request->materiOld;
        if($request->materi){
            $materiName = $request->materi->getClientOriginalName() . '-' . time() . '.'
            .$request->materi->extension();

            $data = DB::table('periodes')->where('id_periode', $id)->first();
            File::delete(public_path() . '/materi/' . $data->materi);
            $request->materi->move(public_path('materi'), $materiName);
        }
        DB::table('periodes')->where('id_periode', $id)->update([
            'periode' => $request->periode,
            'materi' => $materiName
        ]);

        return redirect()->route('periode')->with('pesan', 'Periode berhasil diubah');
    }

    public function delete($id){
        DB::table('periodes')->where('id_periode',$id)->delete();
        DB::table('kelas')->where('id_periode',$id)->delete();
        DB::table('kelompoks')->where('id_periode',$id)->delete();
        DB::table('nilai_mentorings')->where('id_periode',$id)->delete();

        return redirect()->route('periode')->with('pesan', 'Periode berhasil dihapus');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Periode  $periode
     * @return \Illuminate\Http\Response
     */
    public function destroy(Periode $periode)
    {
        //
    }
}
