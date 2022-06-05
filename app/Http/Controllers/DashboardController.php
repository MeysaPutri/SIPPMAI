<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(){
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
        
        $amalan = DB::table('amalan_yaumis')
            ->leftJoin('mahasiswas', 'amalan_yaumis.nim', '=', 'mahasiswas.nim')
            ->leftJoin('detail_mentees', 'mahasiswas.nim', '=', 'detail_mentees.nim')
            ->leftJoin('kelompoks', 'detail_mentees.id_kel', 'kelompoks.id_kel')
            ->leftJoin('detail_mentors', 'kelompoks.id_kel', '=', 'detail_mentors.id_kel')
            ->leftJoin('detail_kelas', 'mahasiswas.nim', '=', 'detail_kelas.nim')
            ->leftJoin('kelas', 'detail_kelas.id_kelas', '=', 'kelas.id_kelas')
            ->leftJoin('dosens', 'kelas.nip', '=', 'dosens.nip')
            ->leftJoin('aktifitas', 'amalan_yaumis.id_aktifitas', '=', 'aktifitas.id_aktifitas')
            ->select(
                'amalan_yaumis.*',
                'mahasiswas.*',
                'detail_mentees.*',
                'kelompoks.*',
                'detail_mentors.*',
                'detail_kelas.*',
                'kelas.*',
                'dosens.*',
                'aktifitas.*'
            )
            ->get();
        
        return view("pages.dashboard.index", compact('periode', 'selectedPeriode'),[
            "periode" => $periode,
            "amalan" => $amalan,
            "selectedPeriode" => $selectedPeriode
        ]);
    }
    
}
