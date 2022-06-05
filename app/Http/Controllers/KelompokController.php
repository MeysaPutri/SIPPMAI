<?php

namespace App\Http\Controllers;

use App\DetailMentor;
use App\Kelompok;
use App\Kelompok_Mentor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class KelompokController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(session('id_role') == 4){
            $periode = $selectedPeriode = DB::table('periodes')->get();
        }
        elseif(session('id_role') == 1){            
            $mentor = DB::table('detail_mentors')
                ->where('nim', session('nip_nim'))->first();
            $max = DB::table('detail_mentors')
                ->leftJoin('kelompoks', 'detail_mentors.id_kel', '=', 'kelompoks.id_kel')
                ->leftJoin('periodes', 'kelompoks.id_periode', '=', 'periodes.id_periode')
                ->where('detail_mentors.nim', $mentor->nim)
                ->max('periodes.id_periode');
            $periode = $selectedPeriode = DB::table('periodes')
                ->where('periodes.id_periode', $max)
                ->get();
        }
        elseif(session('id_role') == 2){ 
            $dosen = DB::table('dosens')
                ->where('nip', session('nip_nim'))->first();
            $max = DB::table('dosens')
                ->leftJoin('kelas', 'dosens.nip', '=', 'kelas.nip')
                ->leftJoin('periodes', 'kelas.id_periode', '=', 'periodes.id_periode')
                ->where('dosens.nip', $dosen->nip)
                ->max('periodes.id_periode');
            $periode = $selectedPeriode = DB::table('periodes')
                ->where('periodes.id_periode', $max)
                ->get();
        }  
        elseif(session('id_role') == 3){ 
            $mentee = DB::table('detail_mentees')
                ->where('nim', session('nip_nim'))->first();
            $max = DB::table('detail_mentees')
                ->leftJoin('kelompoks', 'detail_mentees.id_kel', '=', 'kelompoks.id_kel')
                ->leftJoin('periodes', 'kelompoks.id_periode', '=', 'periodes.id_periode')
                ->where('detail_mentees.nim', $mentee->nim)
                ->max('periodes.id_periode');
            $periode = $selectedPeriode = DB::table('periodes')
                ->where('periodes.id_periode', $max)
                ->get();
        }
        
        if (session('id_role') == 1) {
            $mentor = DB::table('detail_mentors')
                ->where('nim', session('nip_nim'))->first();
            $kelompok = DB::table('kelompoks') 
                ->leftJoin('periodes', 'kelompoks.id_periode', '=', 'periodes.id_periode')
                ->leftJoin('detail_mentors', 'kelompoks.id_kel', '=', 'detail_mentors.id_kel')                
                ->select('kelompoks.*', 'periodes.*', 'detail_mentors.*')
                ->where('detail_mentors.nim', $mentor->nim)
                ->get();
        } else { 
            $kelompok = DB::table('kelompoks') 
            ->leftJoin('periodes', 'kelompoks.id_periode', '=', 'periodes.id_periode')
            ->select('kelompoks.*', 'periodes.*')
            ->get();
        }
        
            
        $periode = DB::table('periodes')->get();

        return view("pages.kelompok.index",compact('periode', 'selectedPeriode'), [
            "kelompok" => $kelompok,
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
        $mentor = DB::table('mahasiswas')
            ->select('mahasiswas.nim', 'mahasiswas.nama_mhs')
            ->get();
        $periode = DB::table('periodes')->get();
        return view('pages.kelompok.create', [
            "periode" => $periode,
            "mentor" => $mentor
        ]);
    }

    public function submit(Request $request)
    {
        $nim = $request->nim;
        foreach($nim as $n){
            DB::table('users')->where('nip_nim', $n)->update([
                'id_role' => 1,
                'password' => Hash::make($request->password),
                'status_aktif' => 'aktif'
            ]);
        }
        

        // DB::table('users')->where('nip_nim', $nim)->update([
        //     'id_role' => 1,
        //     'password' => Hash::make($request->password),
        //     'status_aktif' => 'aktif'
        // ]);

        Kelompok::create([
            'nama_kel' => $request->nama_kel,
            'id_periode' => $request->id_periode
        ]);

        $id_kel = DB::getPdo()->lastInsertId();

        $data = [];
        foreach($request->nim as $value ){
            $data[] =[
                "nim" => $value,
                "id_kel" => $id_kel,
                "created_at" => \Carbon\Carbon::now(),
                "updated_at" => \Carbon\Carbon::now()
            ];
        }

        DetailMentor::insert($data);
        $id_periode = $request->id_periode;
        return redirect()->route('kelompok', ['id_periode'=>$id_periode])->with('pesan', 'Data kelompok berhasil ditambah');
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

    public function delete($id)
    {
        DB::table('kelompoks')->where('id_kel', $id)->delete();
        DB::table('detail_mentors')->where('id_kel',$id)->delete();
        DB::table('detail_mentees')->where('id_kel', $id)->delete();
        DB::table('laporans')
            ->leftJoin('mahasiswas', 'laporans.nim', '=', 'mahasiswas.nim')
            ->leftJoin('detail_mentees', 'mahasiswas.nim', '=', 'laporans.nim')
            ->leftJoin('kelompoks', 'detail_mentees.id_kel', '=', 'kelompoks.id_kel')
            ->where('detail_mentees.id_kel', $id)->delete();

        return redirect()->back()->with('pesan', 'Data kelompok berhasil dihapus');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Kelompok  $kelompok
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $mentor = DB::table('mahasiswas')
            ->leftJoin('detail_mentors', 'mahasiswas.nim', '=', 'detail_mentors.nim')
            ->select('detail_mentors.*', 'mahasiswas.*')
            ->get();
        $kelompok = DB::table('kelompoks')
            ->leftJoin('periodes', 'kelompoks.id_periode','=','periodes.id_periode')
            ->select('kelompoks.*', 'periodes.*')
            ->where('id_kel',$id)->first();
        $detail_mentor = DB::table('detail_mentors')
            ->leftJoin('mahasiswas', 'detail_mentors.nim', '=', 'mahasiswas.nim')
            ->select('mahasiswas.nama_mhs','detail_mentors.nim')
            ->where('id_kel', $id)
            ->get();

        $itemMentor = [];
        foreach($detail_mentor as $item){
            $itemMentor[] = $item->nim;
        }
        $periode = DB::table('periodes')->get();
        return view('pages.kelompok.edit', [
            "kelompok"=> $kelompok,
            "mentor" => $mentor,
            "periode" => $periode,
            "detail_mentor" => $detail_mentor,
            "itemMentor" =>$itemMentor
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
        $nim = $request->nim;
        DB::table('users')->where('nip_nim', $nim)->update([
            'id_role' => 1,
            'password' => Hash::make($request->password),
            'status_aktif' => 'aktif'
        ]);

        DB::table('kelompoks')->where('id_kel', $id)->update([
            'nama_kel' => $request->nama_kel,
            'id_periode' => $request->id_periode
        ]);

        DB::table('detail_mentors')->where('id_kel', $id)->delete();
        
        $data = [];
        foreach($request->nim as $value ){
            $data[] =[
                "nim" => $value,
                "id_kel" => $id,
                "created_at" => \Carbon\Carbon::now(),
                "updated_at" => \Carbon\Carbon::now()
            ];
        }

        DetailMentor::insert($data);
        $id_periode = $request->id_periode;

        return redirect()->route('kelompok', ['id_periode'=>$id_periode])->with('pesan', 'Data kelompok berhasil diubah');
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
