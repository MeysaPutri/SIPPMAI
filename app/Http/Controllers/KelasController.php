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

        if (session('id_role') == 2) {
            $dosen = DB::table('dosens')
                ->where('dosens.nip', session('nip_nim'))->first();
            $kelas = DB::table('kelas')
                ->leftJoin('dosens', 'kelas.nip', '=', 'dosens.nip')
                ->leftJoin('periodes', 'kelas.id_periode', '=', 'periodes.id_periode')
                ->select('kelas.*', 'dosens.*', 'periodes.id_periode', 'periodes.periode')
                ->where('dosens.nip', $dosen->nip)
                ->get();
        } else{        
            $kelas = DB::table('kelas')
                ->leftJoin('dosens', 'kelas.nip', '=', 'dosens.nip')
                ->leftJoin('periodes', 'kelas.id_periode', '=', 'periodes.id_periode')
                ->select('kelas.*', 'dosens.*', 'periodes.id_periode', 'periodes.periode')
                ->get();
        }

        return view("pages.kelas.index", compact('periode', 'selectedPeriode'), [
            "kelas" => $kelas,
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
        $dosen = DB::table('dosens')->get();
        $periode = DB::table('periodes')->get();
        return view('pages.kelas.create', [
            "dosen" => $dosen,
            "periode" => $periode
        ]);
    }

    public function submit(Request $request)
    {
        DB::table('kelas')->insert([
            [
                'id_periode' => $request->id_periode,
                'nama_kelas' => $request->nama_kelas,
                'sks' => $request->sks,
                'nip' => $request->nip
            ]
        ]);

        $id_periode = $request->id_periode; 

        return redirect()->route('kelas', ['id_periode'=>$id_periode])->with('pesan', 'Data kelas berhasil ditambah');
    }

    public function delete($id)
    {
        DB::table('kelas')->where('id_kelas', $id)->delete();

        return redirect()->back()->with('pesan', 'Data kelas berhasil dihapus');
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
    public function show($id)
    {
        // $kelas = DB::table('kelas')->where('id_kelas', $id)->first();

        // $detail_kelas = DB::table('detail_kelas')
        //     ->leftJoin('mahasiswas', 'detail_kelas.nim', '=', 'mahasiswas.nim')
        //     ->leftJoin('kelas', 'detail_kelas.id_kelas', '=', 'kelas.id_kelas')
        //     ->leftJoin('jurusans', 'mahasiswas.id_jurusan', '=', 'jurusans.id_jurusan')
        //     ->where('mahasiswas.nim', $id)
        //     ->select('mahasiswas.nim', 'mahasiswas.nama_mhs', 'jurusans.nama_jurusan', 'mahasiswas.no_hp')
        //     ->get();

        // $dosen = DB::table('kelas')
        //     ->leftJoin('dosens', 'kelas.nip', '=', 'dosens.nip')
        //     ->where('kelas.id_kelas', $id)
        //     ->first();

        // return view('pages.kelas.detail', [
        //     "detail_kelas" => $detail_kelas,
        //     "kelas" => $kelas,
        //     "dosen" => $dosen
        // ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dosen = DB::table('dosens')->get();
        $periode = DB::table('periodes')->get();
        $kelas = DB::table('kelas')
            ->leftJoin('dosens', 'kelas.nip', '=', 'dosens.nip')
            ->leftJoin('periodes', 'kelas.id_periode', '=', 'periodes.id_periode')
            ->select('kelas.*', 'dosens.*', 'periodes.*')
            ->where('id_kelas', $id)->first();
        return view('pages.kelas.edit', [
            "kelas" => $kelas,
            "dosen" => $dosen,
            "periode" => $periode
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
            'id_periode' => $request->id_periode,
            'sks' => $request->sks,
            'nama_kelas' => $request->nama_kelas,
            'nip' => $request->nip
        ]);

        $id_periode = $request->id_periode;
        return redirect()->route('kelas', ['id_periode'=>$id_periode])->with('pesan', 'Data kelas berhasil diubah');
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
