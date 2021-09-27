<?php

namespace App\Http\Controllers;

use App\Mentee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenteeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mentee =  DB::table('mentees')->paginate(10);
        return view('pages.mentee.index',[
            "mentee" => $mentee
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    //method untuk menambah data
    public function create()
    {
        return view ('pages.mentee.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    //method untuk menyimpan data
    public function submit(Request $request)
    {
        DB::table('mentees')->insert([
            ['id_periode' => $request->id_periode,
             'nip_nim' => $request->nip_nim,
             'nim' => $request->nim,
             'id_kelas' => $request->id_kelas]
        ]);

        return redirect()->route('mentee'); 
    }

    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Mentee  $mentee
     * @return \Illuminate\Http\Response
     */
    public function show(Mentee $mentee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Mentee  $mentee
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $mentee = DB::table('mentees')->where('id_mentee',$id)->first();
        return view('pages.mentee.edit', [
            "mentee"=> $mentee
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Mentee  $mentee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::table('mentees')->where('id_mentee', $id)->update([
            'id_periode' => $request->id_periode,
            'nip_nim' => $request->nip_nim,
            'nim' => $request->nim,
            'id_kelas' => $request->id_kelas
        ]);

        return redirect()->route('mentee');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Mentee  $mentee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mentee $mentee)
    {
        //
    }
}
