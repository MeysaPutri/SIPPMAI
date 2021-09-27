<?php

namespace App\Http\Controllers;

use App\Mentor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MentorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mentor =  DB::table('mentors')->paginate(10);
        return view('pages.mentor.index',[
            "mentor" => $mentor
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
        return view('pages.mentor.create');
    }

    //method untuk simpan data
    public function submit(request $request)
    {
        DB::table('mentors')->insert([
            ['id_periode' => $request->id_periode,
             'nip_nim' => $request->nip_nim,
             'nim' => $request->nim]
        ]);

        return redirect()->route('mentor'); 
    }

    //method untuk menghapus data
    public function delete($id)
    {
        DB::table('mentors')->where('id_mentor',$id)->delete();

        return redirect()->back();
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
     * @param  \App\Mentor  $mentor
     * @return \Illuminate\Http\Response
     */
    public function show(Mentor $mentor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Mentor  $mentor
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $mentor = DB::table('mentors')->where('id_mentor',$id)->first();
        return view('pages.mentor.edit', [
            "mentor"=> $mentor
        ]);
    }
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Mentor  $mentor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::table('mentors')->where('id_mentor', $id)->update([
            'id_periode' => $request->id_periode,
            'nip_nim' => $request->nip_nim,
            'nim' => $request->nim
        ]);

        return redirect()->route('mentor');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Mentor  $mentor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mentor $mentor)
    {
        //
    }
}
