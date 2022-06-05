<?php

namespace App\Http\Controllers;

use App\Amalan_Yaumi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AmalanYaumiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()    {

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

        $amalanyaumi = DB::table('amalan_yaumis')
            ->leftJoin('pertemuans', 'amalan_yaumis.id_pertemuan', '=', 'pertemuans.id_pertemuan')
            ->select('amalan_yaumis.nim', 
                'amalan_yaumis.id_pertemuan', 
                'pertemuans.pertemuan'
            )->get();

        $data = [];
        foreach ($amalanyaumi as $key => $value) {
            $data[] = $value->nim;
        }

        $mentee = DB::table('detail_mentees')
            ->leftJoin('mahasiswas', 'detail_mentees.nim', '=', 'mahasiswas.nim')
            ->leftJoin('kelompoks', 'detail_mentees.id_kel', '=', 'kelompoks.id_kel')
            ->leftJoin('periodes', 'kelompoks.id_periode', '=', 'periodes.id_periode')
            ->select('detail_mentees.nim', 'mahasiswas.nama_mhs')
            ->get();

            
        $aktifitas = DB::table('aktifitas')
            ->orderBy('id_aktifitas', 'asc')
            ->get();

        return view("pages.amalan_yaumi.index", compact('periode', 'selectedPeriode'), [
            "mentee" => $mentee,
            "aktifitas" => $aktifitas
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id_aktifitas = $request->id_aktifitas;

        if (DB::table('amalan_yaumis')->where(['nim' => $request->nim, 'id_pertemuan' => $request->id_pertemuan])->exists()) {
            //update
            foreach ($id_aktifitas as $i => $ii) {
                DB::table('amalan_yaumis')->where(['nim' => $request->nim, 'id_pertemuan' => $request->id_pertemuan, 'id_aktifitas' => $ii])->update([
                    'isian' => $request->isian[$i],
                ]);
            }
            return redirect()->back()->with('pesan', 'Amalan yaumi berhasil diubah');
        } else {
            //insert
            foreach ($id_aktifitas as $i => $ii) {
                DB::table('amalan_yaumis')->insert([
                    'nim' => $request->nim,
                    'id_aktifitas' => $ii,
                    'id_pertemuan' => $request->id_pertemuan,
                    'isian' => $request->isian[$i],
                    'pengevaluasi' => $request->pengevaluasi
                ]);
            }
            return redirect()->back()->with('pesan', 'Amalan yaumi berhasil ditambah');
        }
    }

    public function store_evaluasi(Request $request)
    {
        $id_aktifitas = $request->id_aktifitas;

        if (DB::table('amalan_yaumis')->where(['nim' => $request->nim, 'id_pertemuan' => $request->id_pertemuan])->exists()) {
            //update
            foreach ($id_aktifitas as $i => $ii) {
                DB::table('amalan_yaumis')->where(['nim' => $request->nim, 'id_pertemuan' => $request->id_pertemuan, 'id_aktifitas' => $ii])->update([
                    'evaluasi' => $request->evaluasi[$i],
                    'pengevaluasi' => $request->pengevaluasi
                ]);
            }
            return redirect()->back()->with('pesan', 'Evaluasi berhasil disimpan');
        } else {
            return redirect()->back();
        }
    }
    

    /**
     * Display the specified resource.
     *
     * @param  \App\Amalan_Yaumi  $amalan_Yaumi
     * @return \Illuminate\Http\Response
     */
    public function show(Amalan_Yaumi $amalan_Yaumi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Amalan_Yaumi  $amalan_Yaumi
     * @return \Illuminate\Http\Response
     */
    public function edit(Amalan_Yaumi $amalan_Yaumi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Amalan_Yaumi  $amalan_Yaumi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Amalan_Yaumi $amalan_Yaumi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Amalan_Yaumi  $amalan_Yaumi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Amalan_Yaumi $amalan_Yaumi)
    {
        //
    }
}
