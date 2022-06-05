<?php

namespace App\Http\Controllers;

use App\SCM;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SCMController extends Controller
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
            //mentor
            $mentor = DB::table('mahasiswas')
                ->leftJoin('detail_mentors', 'mahasiswas.nim', '=', 'detail_mentors.nim') 
                ->select('detail_mentors.*', 'mahasiswas.*')
                ->where('mahasiswas.nim', session('nip_nim'))->first();
            $scm = DB::table('scms')
                ->leftJoin('mahasiswas', 'scms.nim', '=', 'mahasiswas.nim')
                ->leftJoin('detail_mentees', 'mahasiswas.nim', '=', 'detail_mentees.nim')
                ->leftJoin('kelompoks', 'detail_mentees.id_kel', '=', 'kelompoks.id_kel')
                ->leftJoin('detail_mentors', 'kelompoks.id_kel', '=', 'detail_mentors.id_kel')
                ->leftJoin('periodes', 'kelompoks.id_periode', '=', 'periodes.id_periode')
                ->leftJoin('detail_kelas', 'mahasiswas.nim', '=', 'detail_kelas.nim')
                ->leftJoin('kelas', 'detail_kelas.id_kelas', '=', 'kelas.id_kelas')
                ->leftJoin('dosens', 'kelas.nip', '=', 'dosens.nip')
                ->leftJoin('statuses', 'scms.id_status', '=', 'statuses.id_status')
                ->where('detail_mentors.nim', $mentor->nim)
                ->get();
        } elseif (session('id_role') == 4) {
            //admin
            $scm = DB::table('scms')
                ->leftJoin('mahasiswas', 'scms.nim', '=', 'mahasiswas.nim')
                ->leftJoin('detail_mentees', 'mahasiswas.nim', '=', 'detail_mentees.nim')
                ->leftJoin('kelompoks', 'detail_mentees.id_kel', '=', 'kelompoks.id_kel')
                ->leftJoin('periodes', 'kelompoks.id_periode', '=', 'periodes.id_periode')
                ->leftJoin('detail_kelas', 'mahasiswas.nim', '=', 'detail_kelas.nim')
                ->leftJoin('kelas', 'detail_kelas.id_kelas', '=', 'kelas.id_kelas')
                ->leftJoin('dosens', 'kelas.nip', '=', 'dosens.nip')
                ->leftJoin('statuses', 'scms.id_status', '=', 'statuses.id_status')
                ->get();
        }
        
        return view('pages.scm.index', compact('periode', 'selectedPeriode'), [
            "scm" => $scm,
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

        return view('pages.scm.create',[
        ]);
    }

    public function persetujuan()
    {
        $mentee = DB::table('mahasiswas')
            ->leftJoin('detail_mentors', 'mahasiswas.nim', '=', 'detail_mentors.nim') 
            ->select('detail_mentors.*', 'mahasiswas.*')
            ->where('mahasiswas.nim', session('nip_nim'))->first();

        $scm = DB::table('scms')
            ->leftJoin('mahasiswas', 'scms.nim', '=', 'mahasiswas.nim')
            ->where('scms.nim', $mentee->nim)
            ->get();

        return view('pages.scm.persetujuan',[
            "scm" => $scm
        ]);
    }

    public function edit($id)
    {
        $scm = DB::table('scms')
            ->select('scms.*')
            ->where('nim', $id)
            ->first();
        return view('pages.scm.edit',[
            "scm" => $scm
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'sedia' => 'required',
            'alasan' => 'required'
        ]);

        $sedia = $request->sedia;
        if($sedia==0){
            DB::table('scms')->where('nim', $id)->update([
                'sedia' => $request->sedia,
                'alasan' => $request->alasan
            ]);
        }else{
            DB::table('scms')->where('nim', $id)->update([
                'sedia' => $request->sedia,
                'alasan' => NULL
            ]);
        } 

        return redirect()->route('persetujuan.scm')->with('pesan', 'Data SCM Anda berhasil diubah');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function submit(Request $request)
    {   
        $sedia = $request ->sedia;
        if($sedia == 1){
            DB::table('scms')->where($sedia == 1)->insert([
                'nim'=> $request->nim,
                'id_status' => 3,
                'sedia'=> 1,
                'alasan'=>NULL 
            ]);
            return redirect()->route('dashboard')->with('pesan', 'Selamat Anda telah berhasil menjadi salah satu Suplemen Calon Mentor'); 
        }
        elseif($sedia == 0){
            $validated = $request->validate([
                'sedia' => 'required',
                'alasan' => 'required',
            ]);        

            DB::table('scms')->where($sedia == 0)->insert([
                'nim'=> $request->nim,
                'id_status' => 3,
                'sedia'=> 0,
                'alasan'=>$request->alasan
            ]);

            return redirect()->route('dashboard',[
                'validate' => $validated
            ])->with('error', 'Maaf, Anda gagal menjadi Suplemen Calon Mentor. Tapi tenang, alasan Anda akan kami pertimbangkan lagi'); 
        }
    }

    public function status($id)
    {
        $scm = DB::table('scms')->where('nim', $id)->first();
        $now = $scm->id_status;
        if($now == 2)
        {
            DB::table('scms')->where('nim', $id)->update([
                'id_status' => 1
            ]);
        }
        elseif($now == 1){
            DB::table('scms')->where('nim', $id)->update([
                'id_status' => 3
            ]);
        }
        elseif($now == 3){
            DB::table('scms')->where('nim', $id)->update([
                'id_status' => 2
            ]);
        }
        return redirect()->back()->with('pesan', 'Status SCM mentee berhasil diubah');  
    }

    public function scm_cetak() //method untuk menampilkan view cetak
    {
        return view('pages.scm.cetak_view');
    }

    public function store(Request $r)
    {
        $key = $r->key;
        if($key == 'all'){
            //cetak semua data
            $scm = DB::table('scms')
                ->leftJoin('mahasiswas', 'scms.nim', '=', 'mahasiswas.nim')
                ->leftJoin('jurusans', 'mahasiswas.id_jurusan', '=', 'jurusans.id_jurusan')
                ->leftJoin('fakultas', 'jurusans.id_fakultas', '=', 'fakultas.id_fakultas')
                ->leftJoin('detail_mentees', 'mahasiswas.nim', '=', 'detail_mentees.nim')
                ->leftJoin('kelompoks', 'detail_mentees.id_kel', '=', 'kelompoks.id_kel')
                ->leftJoin('detail_kelas', 'mahasiswas.nim', '=', 'detail_kelas.nim')
                ->leftJoin('kelas', 'detail_kelas.id_kelas', '=', 'kelas.id_kelas')
                ->leftJoin('dosens', 'kelas.nip', '=', 'dosens.nip')
                ->leftJoin('statuses', 'scms.id_status', '=', 'statuses.id_status')
                ->where('kelompoks.id_periode', $r->id_periode)
                ->get();
            
            return view('pages.scm.cetak', [
                "scm" => $scm,
                'periode' => DB::table('periodes')->where('id_periode', $r->id_periode)->first(),
                'ket1' => 'Keterangan',
                'val1' => 'Keseluruhan',

                'ket2' => 'Jumlah Mentee',
                'val2' => DB::table('scms')                            
                            ->leftJoin('mahasiswas', 'scms.nim', '=', 'mahasiswas.nim')
                            ->leftJoin('detail_mentees', 'mahasiswas.nim', '=', 'detail_mentees.nim')
                            ->leftJoin('kelompoks', 'detail_mentees.id_kel', '=', 'kelompoks.id_kel')
                            ->leftJoin('periodes', 'kelompoks.id_periode', '=', 'periodes.id_periode')
                            ->where('kelompoks.id_periode', $r->id_periode)
                            ->select('nim')->count()
            ]);
        }
        elseif($key == 'approve'){
            //cetak yang approve saja, id_status == 1
            $scm = DB::table('scms')
                ->leftJoin('mahasiswas', 'scms.nim', '=', 'mahasiswas.nim')
                ->leftJoin('jurusans', 'mahasiswas.id_jurusan', '=', 'jurusans.id_jurusan')
                ->leftJoin('fakultas', 'jurusans.id_fakultas', '=', 'fakultas.id_fakultas')
                ->leftJoin('detail_mentees', 'mahasiswas.nim', '=', 'detail_mentees.nim')
                ->leftJoin('kelompoks', 'detail_mentees.id_kel', '=', 'kelompoks.id_kel')
                ->leftJoin('detail_kelas', 'mahasiswas.nim', '=', 'detail_kelas.nim')
                ->leftJoin('kelas', 'detail_kelas.id_kelas', '=', 'kelas.id_kelas')
                ->leftJoin('dosens', 'kelas.nip', '=', 'dosens.nip')
                ->leftJoin('statuses', 'scms.id_status', '=', 'statuses.id_status')
                ->where('scms.id_status', 1)
                ->where('kelompoks.id_periode', $r->id_periode)
                ->get();
            
            return view('pages.scm.cetak', [
                "scm" => $scm,
                'periode' => DB::table('periodes')->where('id_periode', $r->id_periode)->first(),
                'ket1' => 'Keterangan',
                'val1' => 'Approve',

                'ket2' => 'Jumlah Mentee',
                'val2' => DB::table('scms')                            
                            ->leftJoin('mahasiswas', 'scms.nim', '=', 'mahasiswas.nim')
                            ->leftJoin('detail_mentees', 'mahasiswas.nim', '=', 'detail_mentees.nim')
                            ->leftJoin('kelompoks', 'detail_mentees.id_kel', '=', 'kelompoks.id_kel')
                            ->leftJoin('periodes', 'kelompoks.id_periode', '=', 'periodes.id_periode')
                            ->where('kelompoks.id_periode', $r->id_periode)
                            ->select('nim')->where('id_status', 1)->count()
            ]);
        }
        elseif($key == 'disapprove'){
            //cetak yang disapprove saja,  id_status == 2
            $scm = DB::table('scms')
                ->leftJoin('mahasiswas', 'scms.nim', '=', 'mahasiswas.nim')
                ->leftJoin('jurusans', 'mahasiswas.id_jurusan', '=', 'jurusans.id_jurusan')
                ->leftJoin('fakultas', 'jurusans.id_fakultas', '=', 'fakultas.id_fakultas')
                ->leftJoin('detail_mentees', 'mahasiswas.nim', '=', 'detail_mentees.nim')
                ->leftJoin('kelompoks', 'detail_mentees.id_kel', '=', 'kelompoks.id_kel')
                ->leftJoin('detail_kelas', 'mahasiswas.nim', '=', 'detail_kelas.nim')
                ->leftJoin('kelas', 'detail_kelas.id_kelas', '=', 'kelas.id_kelas')
                ->leftJoin('dosens', 'kelas.nip', '=', 'dosens.nip')
                ->leftJoin('statuses', 'scms.id_status', '=', 'statuses.id_status')
                ->where('scms.id_status', 2)
                ->where('kelompoks.id_periode', $r->id_periode)
                ->get();
            
            return view('pages.scm.cetak', [
                "scm" => $scm,
                'periode' => DB::table('periodes')->where('id_periode', $r->id_periode)->first(),
                'ket1' => 'Keterangan',
                'val1' => 'Approve',

                'ket2' => 'Jumlah Mentee',
                'val2' => DB::table('scms')            
                            ->leftJoin('mahasiswas', 'scms.nim', '=', 'mahasiswas.nim')
                            ->leftJoin('detail_mentees', 'mahasiswas.nim', '=', 'detail_mentees.nim')
                            ->leftJoin('kelompoks', 'detail_mentees.id_kel', '=', 'kelompoks.id_kel')
                            ->leftJoin('periodes', 'kelompoks.id_periode', '=', 'periodes.id_periode')
                            ->where('kelompoks.id_periode', $r->id_periode)
                            ->select('nim')->where('id_status', 2)->count()
            ]);
        }
        elseif($key == 'in review'){
            //cetak yang in review saja,  id_status == 3
            $scm = DB::table('scms')
                ->leftJoin('mahasiswas', 'scms.nim', '=', 'mahasiswas.nim')
                ->leftJoin('jurusans', 'mahasiswas.id_jurusan', '=', 'jurusans.id_jurusan')
                ->leftJoin('fakultas', 'jurusans.id_fakultas', '=', 'fakultas.id_fakultas')
                ->leftJoin('detail_mentees', 'mahasiswas.nim', '=', 'detail_mentees.nim')
                ->leftJoin('kelompoks', 'detail_mentees.id_kel', '=', 'kelompoks.id_kel')
                ->leftJoin('detail_kelas', 'mahasiswas.nim', '=', 'detail_kelas.nim')
                ->leftJoin('kelas', 'detail_kelas.id_kelas', '=', 'kelas.id_kelas')
                ->leftJoin('dosens', 'kelas.nip', '=', 'dosens.nip')
                ->leftJoin('statuses', 'scms.id_status', '=', 'statuses.id_status')
                ->where('scms.id_status', 3)
                ->where('kelompoks.id_periode', $r->id_periode)
                ->get();
            
            return view('pages.scm.cetak_inreview', [
                "scm" => $scm,
                'periode' => DB::table('periodes')->where('id_periode', $r->id_periode)->first(),
                'ket1' => 'Keterangan',
                'val1' => 'In review',

                'ket2' => 'Jumlah Mentee',
                'val2' => DB::table('scms')                                                        
                            ->leftJoin('mahasiswas', 'scms.nim', '=', 'mahasiswas.nim')
                            ->leftJoin('detail_mentees', 'mahasiswas.nim', '=', 'detail_mentees.nim')
                            ->leftJoin('kelompoks', 'detail_mentees.id_kel', '=', 'kelompoks.id_kel')
                            ->leftJoin('periodes', 'kelompoks.id_periode', '=', 'periodes.id_periode')
                            ->where('kelompoks.id_periode', $r->id_periode)
                            ->select('nim')->where('id_status', 3)->count()
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SCM  $sCM
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $items = DB::table('scms')
            ->leftJoin('mahasiswas', 'scms.nim', '=', 'mahasiswas.nim')
            ->leftJoin('jurusans', 'mahasiswas.id_jurusan', '=', 'jurusans.id_jurusan')
            ->leftJoin('fakultas', 'jurusans.id_fakultas', '=', 'fakultas.id_fakultas')
            ->leftJoin('detail_mentees', 'mahasiswas.nim', '=', 'detail_mentees.nim')
            ->leftJoin('kelompoks', 'detail_mentees.id_kel', '=', 'kelompoks.id_kel')
            ->leftJoin('periodes', 'kelompoks.id_periode', '=', 'periodes.id_periode')
            ->leftJoin('detail_kelas', 'mahasiswas.nim', '=', 'detail_kelas.nim')
            ->leftJoin('kelas', 'detail_kelas.id_kelas', '=', 'kelas.id_kelas')
            ->leftJoin('dosens', 'kelas.nip', '=', 'dosens.nip')
            ->leftJoin('statuses', 'scms.id_status', '=', 'statuses.id_status')
            ->where('scms.nim', $id)
            ->first();
        
        $status = DB::table('statuses')
            ->leftJoin('scms', 'statuses.id_status', '=', 'scms.id_status')
            ->where('scms.nim', $id)
            ->get();
        
        return view('pages.scm.detail', [
            "items" => $items,
            "id" => $id,
            "status" => $status
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SCM  $sCM
     * @return \Illuminate\Http\Response
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SCM  $sCM
     * @return \Illuminate\Http\Response
     */

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SCM  $sCM
     * @return \Illuminate\Http\Response
     */
    public function destroy(SCM $sCM)
    {
        //
    }
}
