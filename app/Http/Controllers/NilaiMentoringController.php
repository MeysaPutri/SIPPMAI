<?php

namespace App\Http\Controllers;

use App\Nilai_Mentoring;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NilaiMentoringController extends Controller
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

        return view("pages.nilai.index", compact('periode', 'selectedPeriode'), [
            "periode" =>$periode
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $nilai = DB::table('nilai_mentorings')
            ->select('nim')
            ->get();

        $data = [];
        foreach ($nilai as $key => $value) {
            $data[] = $value->nim;
        }

        $detail_mentor = DB::table('detail_mentors')
            ->leftJoin('kelompoks', 'detail_mentors.id_kel', '=', 'kelompoks.id_kel')
            ->where('detail_mentors.nim', session('nip_nim'))->first();

        $max = DB::table('detail_mentors')
            ->leftJoin('kelompoks', 'detail_mentors.id_kel', '=', 'kelompoks.id_kel')
            ->leftJoin('periodes', 'kelompoks.id_periode', '=', 'periodes.id_periode')
            ->where('detail_mentors.nim', $detail_mentor->nim)
            ->max('periodes.id_periode');

        $mentee = DB::table('detail_mentees')
            ->leftJoin('mahasiswas', 'detail_mentees.nim', '=', 'mahasiswas.nim')
            ->leftJoin('kelompoks', 'detail_mentees.id_kel', '=', 'kelompoks.id_kel')
            ->leftJoin('periodes', 'kelompoks.id_periode', '=', 'periodes.id_periode')
            ->where('kelompoks.id_periode', $max)->get();

        return view("pages.nilai.create", [
            "mentee" => $mentee
        ]);
    }

    public function api_mentee(Request $r)
    {
        $id_mentee = $r->nim;
        $nim = DB::table('detail_mentees')
            ->leftJoin('mahasiswas', 'detail_mentees.nim', '=', 'mahasiswas.nim')
            ->where('mahasiswas.nim', $id_mentee)->first()->nim;
        
        $periode = DB::table('detail_mentees')
            ->leftJoin('kelompoks', 'detail_mentees.id_kel', '=', 'kelompoks.id_kel')
            ->leftJoin('periodes', 'kelompoks.id_periode', '=', 'periodes.id_periode')
            ->where('detail_mentees.nim', $nim)
            ->first();


        $fakultas = DB::table('mahasiswas')
            ->leftJoin('jurusans', 'mahasiswas.id_jurusan', '=', 'jurusans.id_jurusan')
            ->leftJoin('fakultas', 'jurusans.id_fakultas', '=', 'fakultas.id_fakultas')
            ->where('mahasiswas.nim', $nim)
            ->first();

        $kelas = DB::table('detail_kelas')
            ->leftJoin('kelas', 'detail_kelas.id_kelas', '=', 'kelas.id_kelas')
            ->where('detail_kelas.nim', $nim)
            ->first();

        $kelompok = DB::table('detail_mentees')
            ->leftJoin('kelompoks', 'detail_mentees.id_kel', '=', 'kelompoks.id_kel')
            ->where('detail_mentees.nim', $nim)
            ->first();
            
        $data = [
            'pesan' => 'ok',
            'periode' => $periode,
            'fakultas' => $fakultas,
            'kelas' => $kelas,
            'kelompok' => $kelompok,
        ];
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function submit(Request $r)
    {
        $hadir = $r->hadir;
        $izin = $r->izin;
        $alfa = $r->alfa;
        $pertemuan_ujian = $r->pertemuan_ujian;
        $total_kehadiran = ($hadir + $pertemuan_ujian) * 2;

        $npendalaman_materi = $r->npendalaman_materi;
        $total_pendalaman = $npendalaman_materi * 0.2;

        $baca_alquran = $r->baca_alquran;
        $hafalan = $r->hafalan;
        $total_bbq = (($baca_alquran + $hafalan) / 2) * 0.25;

        $wudu = $r->wudu;
        $shalat = $r->shalat;
        $total_ibadah = (($wudu + $shalat) / 2) * 0.25;

        $akhlak = $r->akhlak;
        $total_akhlak = $akhlak * 0.1;

        $total_nilai = ($total_kehadiran + $total_pendalaman + $total_bbq + $total_ibadah + $total_akhlak);

        $penilai = $r->penilai;
        // var_dump($total_nilai_hadir, $total_pendalaman_materi, $total_bbq, $total_praktek_ibadah, $total_akhlak, $total_nilai);
        // die();

        $data = [
            'nim' => $r->nim,
            'hadir' => $hadir,
            'izin' => $izin,
            'alfa' => $alfa,
            'pertemuan_ujian' => $pertemuan_ujian,
            'total_kehadiran' =>$total_kehadiran,
            'npendalaman_materi' => $npendalaman_materi,
            'total_pendalaman' => $total_pendalaman,
            'baca_alquran' => $baca_alquran,
            'hafalan' => $hafalan,
            'total_bbq' => $total_bbq,
            'wudu' => $wudu,
            'shalat' => $shalat,
            'total_ibadah' => $total_ibadah,
            'akhlak' => $akhlak,
            'total_akhlak' => $total_akhlak,
            'total_nilai' => $total_nilai,
            'penilai' =>$penilai
        ];

        DB::table('nilai_mentorings')->insert($data);

        $id_periode = $r->id_periode;
        return redirect()->route('nilai', ['id_periode'=>$id_periode])->with('pesan', 'Nilai mentoring berhasil ditambah');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Nilai_Mentoring  $nilai_Mentoring
     * @return \Illuminate\Http\Response
     */
    public function show($id_nm)
    {
        $nilai = DB::table('nilai_mentorings')
            ->leftJoin('mahasiswas', 'nilai_mentorings.nim', '=', 'mahasiswas.nim')
            ->leftJoin('detail_kelas', 'mahasiswas.nim', '=', 'detail_kelas.nim')
            ->leftJoin('kelas', 'detail_kelas.id_kelas', '=', 'kelas.id_kelas')
            ->leftJoin('jurusans', 'mahasiswas.id_jurusan', '=', 'jurusans.id_jurusan')
            ->leftJoin('fakultas', 'jurusans.id_fakultas', '=', 'fakultas.id_fakultas')
            ->leftJoin('detail_mentees', 'mahasiswas.nim', '=', 'detail_mentees.nim')
            ->leftJoin('kelompoks', 'detail_mentees.id_kel', '=', 'kelompoks.id_kel')
            ->leftJoin('periodes', 'kelompoks.id_periode', '=', 'periodes.id_periode')
            ->where('nilai_mentorings.id_nm', $id_nm)
            ->first();

        return view('pages.nilai.detail', [
            'nilai' => $nilai,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Nilai_Mentoring  $nilai_Mentoring
     * @return \Illuminate\Http\Response
     */
    public function edit(Nilai_Mentoring $nilai_Mentoring, $id)
    {
        $nilai = $fakultas = DB::table('nilai_mentorings')
            ->leftJoin('mahasiswas', 'nilai_mentorings.nim', '=', 'mahasiswas.nim')
            ->leftJoin('detail_kelas', 'mahasiswas.nim', '=', 'detail_kelas.nim')
            ->leftJoin('kelas', 'detail_kelas.id_kelas', '=', 'kelas.id_kelas')
            ->leftJoin('jurusans', 'mahasiswas.id_jurusan', '=', 'jurusans.id_jurusan')
            ->leftJoin('fakultas', 'jurusans.id_fakultas', '=', 'fakultas.id_fakultas')
            ->leftJoin('detail_mentees', 'mahasiswas.nim', '=', 'detail_mentees.nim')
            ->leftJoin('kelompoks', 'detail_mentees.id_kel', '=', 'kelompoks.id_kel')
            ->leftJoin('periodes', 'kelompoks.id_periode', '=', 'periodes.id_periode')
            ->where('nilai_mentorings.id_nm', $id)
            ->first();
        return view("pages.nilai.edit", [
            'nilai' => $nilai,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Nilai_Mentoring  $nilai_Mentoring
     * @return \Illuminate\Http\Response
     */
    public function update(Request $r, $id)
    {
        $hadir = $r->hadir;
        $izin = $r->izin;
        $alfa = $r->alfa;
        $pertemuan_ujian = $r->pertemuan_ujian;
        $total_kehadiran = ($hadir + $pertemuan_ujian) * 2;

        $npendalaman_materi = $r->npendalaman_materi;
        $total_pendalaman = $npendalaman_materi * 0.2;

        $baca_alquran = $r->baca_alquran;
        $hafalan = $r->hafalan;
        $total_bbq = (($baca_alquran + $hafalan) / 2) * 0.25;

        $wudu = $r->wudu;
        $shalat = $r->shalat;
        $total_ibadah = (($wudu + $shalat) / 2) * 0.25;

        $akhlak = $r->akhlak;
        $total_akhlak = $akhlak * 0.1;

        $total_nilai = ($total_kehadiran + $total_pendalaman + $total_bbq + $total_ibadah + $total_akhlak);

        $penilai = $r->penilai;
        // var_dump($total_nilai_hadir, $total_pendalaman_materi, $total_bbq, $total_praktek_ibadah, $total_akhlak, $total_nilai);
        // die();

        $data = [
            'nim' => $r->nim,
            'hadir' => $hadir,
            'izin' => $izin,
            'alfa' => $alfa,
            'pertemuan_ujian' => $pertemuan_ujian,
            'total_kehadiran' =>$total_kehadiran,
            'npendalaman_materi' => $npendalaman_materi,
            'total_pendalaman' => $total_pendalaman,
            'baca_alquran' => $baca_alquran,
            'hafalan' => $hafalan,
            'total_bbq' => $total_bbq,
            'wudu' => $wudu,
            'shalat' => $shalat,
            'total_ibadah' => $total_ibadah,
            'akhlak' => $akhlak,
            'total_akhlak' => $total_akhlak,
            'total_nilai' => $total_nilai,
            'penilai' =>$penilai
        ];

        $id_periode = $r->id_periode;

        DB::table('nilai_mentorings')->where('id_nm', $id)->update($data);
        return redirect()->route('nilai', ['id_periode'=>$id_periode])->with('pesan', 'Nilai mentoring berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Nilai_Mentoring  $nilai_Mentoring
     * @return \Illuminate\Http\Response
     */
    public function delete($id_nm)
    {
        DB::table('nilai_mentorings')->where('id_nm', $id_nm)->delete();
        return redirect()->back()->with('pesan', 'Nilai mentoring berhasil dihapus');
    }

    public function dropdown(Request $r) //method untuk menampilkan view cetak
    {
        $id_periode = $r->id_periode;

        $kelas = DB::table('kelas')
            ->leftJoin('periodes', 'kelas.id_periode', 'periodes.id_periode')
            ->where('kelas.id_periode', $id_periode)
            ->get();

        $fakultas = DB::table('fakultas')
            ->leftJoin('jurusans', 'fakultas.id_fakultas', '=', 'jurusans.id_fakultas')
            ->leftJoin('mahasiswas', 'jurusans.id_jurusan', '=', 'mahasiswas.id_jurusan')
            ->leftJoin('detail_kelas', 'mahasiswas.nim', '=', 'detail_kelas.nim')
            ->leftJoin('kelas', 'detail_kelas.id_kelas', '=', 'kelas.id_kelas')
            ->leftJoin('periodes', 'kelas.id_periode', 'periodes.id_periode')
            ->where('kelas.id_periode', $id_periode)
            ->select('fakultas.*')
            ->distinct()
            ->get();       

        $kelompok = DB::table('kelompoks')
            ->leftJoin('periodes', 'kelompoks.id_periode', 'periodes.id_periode')
            ->where('kelompoks.id_periode', $id_periode)
            ->get();
            
        $data = [
            'pesan' => 'ok',
            'fakultas' => $fakultas,
            'kelas' => $kelas,
            'kelompok' => $kelompok,
        ];
        return response()->json($data);
    }

    public function nilai_cetak() //method untuk menampilkan view cetak
    {
        $periode = DB::table('periodes')->get();
        return view('pages.nilai.cetak_view',[
            "periode" => $periode
        ]);
    }

    public function cetak(Request $r) //method untuk mengambil nilai cetak(store) dan mencetaknya
    {
        $key = $r->key;

        $kelas = DB::table('kelas')
                    ->leftJoin('periodes', 'kelas.id_periode', '=', 'periodes.id_periode')
                    ->where('kelas.id_periode', $r->id_periode)
                    ->get();
        
        $fakultas = DB::table('fakultas')
            ->leftJoin('jurusans', 'fakultas.id_fakultas', '=', 'jurusans.id_fakultas')
            ->leftJoin('mahasiswas', 'jurusans.id_jurusan', '=', 'mahasiswas.id_jurusan')
            ->leftJoin('detail_kelas', 'mahasiswas.nim', '=', 'detail_kelas.nim')
            ->leftJoin('kelas', 'detail_kelas.id_kelas', '=', 'kelas.id_kelas')
            ->leftJoin('periodes', 'kelas.id_periode', '=', 'periodes.id_periode')
            ->where('kelas.id_periode', $r->id_periode)
            ->select('fakultas.*')
            ->distinct()
            ->get();
        
        $kelompok = DB::table('kelompoks')
            ->leftJoin('periodes', 'kelompoks.id_periode', '=', 'periodes.id_periode')
            ->where('kelompoks.id_periode', $r->id_periode)
            ->get();
        
        if($key == 'keseluruhan'){
            if($r->semua == 'semuakelas'){
                foreach ($kelas as $k => $kk) {
                    $a[] = [
                        'nama_kelas' => $kk->nama_kelas,
                        'nama_dosen' => DB::table('kelas')
                            ->join('dosens', 'kelas.nip', '=', 'dosens.nip')
                            ->where('kelas.id_kelas', $kk->id_kelas)
                            ->first()->nama_dosen,
                        'jml_mhs' => DB::table('nilai_mentorings')
                            ->leftJoin('mahasiswas', 'nilai_mentorings.nim', '=', 'mahasiswas.nim')
                            ->leftJoin('detail_kelas', 'mahasiswas.nim', '=', 'detail_kelas.nim')
                            ->leftJoin('kelas', 'detail_kelas.id_kelas', '=', 'kelas.id_kelas')
                            ->where('detail_kelas.id_kelas', $kk->id_kelas)->count(),
                        'data_mhs' => DB::table('nilai_mentorings')
                            ->leftJoin('mahasiswas', 'nilai_mentorings.nim', '=', 'mahasiswas.nim')
                            ->leftJoin('detail_kelas', 'mahasiswas.nim', '=', 'detail_kelas.nim')
                            ->leftJoin('kelas', 'detail_kelas.id_kelas', '=', 'kelas.id_kelas')
                            ->leftJoin('jurusans', 'mahasiswas.id_jurusan', '=', 'jurusans.id_jurusan')
                            ->leftJoin('fakultas', 'jurusans.id_fakultas', '=', 'fakultas.id_fakultas')
                            ->leftJoin('periodes', 'kelas.id_periode', '=', 'periodes.id_periode')
                            ->where('kelas.id_kelas', $kk->id_kelas)
                            ->where('kelas.id_periode', $r->id_periode)
                            ->get(),
                    ];
                }
                $data['nilai'] = $a;
                $data['periode'] = DB::table('periodes')->where('id_periode', $r->id_periode)->first()->periode;
                return view('pages.nilai.cetak_all_kelas', $data);
            }if($r->semua == 'semuafakultas'){
                foreach ($fakultas as $f => $ff) {
                    $a[] = [
                        'nama_fakultas' => $ff->nama_fakultas,
                        'jml_mhs' => DB::table('nilai_mentorings')
                            ->leftJoin('mahasiswas', 'nilai_mentorings.nim', '=', 'mahasiswas.nim')                            
                            ->leftJoin('jurusans', 'mahasiswas.id_jurusan', '=', 'jurusans.id_jurusan')
                            ->leftJoin('fakultas', 'jurusans.id_fakultas', '=', 'fakultas.id_fakultas')
                            ->leftJoin('detail_kelas', 'mahasiswas.nim', '=', 'detail_kelas.nim')
                            ->leftJoin('kelas', 'detail_kelas.id_kelas', '=', 'kelas.id_kelas')
                            ->leftJoin('periodes', 'kelas.id_periode', '=', 'periodes.id_periode')
                            ->where('kelas.id_periode', $r->id_periode)
                            ->where('fakultas.id_fakultas', $ff->id_fakultas)->count(),
                        'data_mhs' => DB::table('nilai_mentorings')
                            ->leftJoin('mahasiswas', 'nilai_mentorings.nim', '=', 'mahasiswas.nim')
                            ->leftJoin('detail_kelas', 'mahasiswas.nim', '=', 'detail_kelas.nim')
                            ->leftJoin('kelas', 'detail_kelas.id_kelas', '=', 'kelas.id_kelas')
                            ->leftJoin('periodes', 'kelas.id_periode', '=', 'periodes.id_periode')
                            ->leftJoin('jurusans', 'mahasiswas.id_jurusan', '=', 'jurusans.id_jurusan')
                            ->leftJoin('fakultas', 'jurusans.id_fakultas', '=', 'fakultas.id_fakultas')
                            ->where('fakultas.id_fakultas', $ff->id_fakultas)
                            ->where('kelas.id_periode', $r->id_periode)
                            ->distinct()
                            ->get(),
                    ];
                }
                $data['nilai'] = $a;
                $data['periode'] = DB::table('periodes')->where('id_periode', $r->id_periode)->first()->periode;
                return view('pages.nilai.cetak_all_fakultas', $data);
            }if($r->semua == 'semuakelompok'){
                foreach ($kelompok as $k => $kk) {
                    $a[] = [
                        'nama_kelompok' => DB::table('kelompoks')->where('id_kel', $kk->id_kel)->first()->nama_kel,
                        'mentor' => DB::table('detail_mentors')
                            ->leftJoin('mahasiswas', 'detail_mentors.nim', '=', 'mahasiswas.nim')
                            ->leftJoin('kelompoks', 'detail_mentors.id_kel', '=', 'kelompoks.id_kel')
                            ->where('detail_mentors.id_kel', $kk->id_kel)
                            ->get(),
                        'jml_mhs' => DB::table('nilai_mentorings')
                            ->leftJoin('mahasiswas', 'nilai_mentorings.nim', '=', 'mahasiswas.nim')
                            ->leftJoin('detail_mentees', 'mahasiswas.nim', '=', 'detail_mentees.nim')
                            ->leftJoin('kelompoks', 'detail_mentees.id_kel', '=', 'kelompoks.id_kel')
                            ->leftJoin('periodes', 'kelompoks.id_periode', '=', 'periodes.id_periode')
                            ->where('detail_mentees.id_kel', $kk->id_kel)->count(),
                        'data_mhs' => DB::table('nilai_mentorings')
                            ->leftJoin('mahasiswas', 'nilai_mentorings.nim', '=', 'mahasiswas.nim')
                            ->leftJoin('detail_kelas', 'mahasiswas.nim', '=', 'detail_kelas.nim')
                            ->leftJoin('kelas', 'detail_kelas.id_kelas', '=', 'kelas.id_kelas')
                            ->leftJoin('jurusans', 'mahasiswas.id_jurusan', '=', 'jurusans.id_jurusan')
                            ->leftJoin('fakultas', 'jurusans.id_fakultas', '=', 'fakultas.id_fakultas')
                            ->leftJoin('detail_mentees', 'mahasiswas.nim', '=', 'detail_mentees.nim')
                            ->leftJoin('kelompoks', 'detail_mentees.id_kel', '=', 'kelompoks.id_kel')
                            ->where('detail_mentees.id_kel', $kk->id_kel)
                            ->where('kelompoks.id_periode', $r->id_periode)
                            ->get(),
                    ];
                }
                $data['nilai'] = $a;
                $data['periode'] = DB::table('periodes')->where('id_periode', $r->id_periode)->first()->periode;
                return view('pages.nilai.cetak_all_kelompok', $data);
            }
        }elseif($key == 'kelas'){
            if($r->id_kelas){
                $nilai = DB::table('nilai_mentorings')
                    ->leftJoin('mahasiswas', 'nilai_mentorings.nim', '=', 'mahasiswas.nim')
                    ->leftJoin('detail_kelas', 'mahasiswas.nim', '=', 'detail_kelas.nim')
                    ->leftJoin('kelas', 'detail_kelas.id_kelas', '=', 'kelas.id_kelas')
                    ->leftJoin('jurusans', 'mahasiswas.id_jurusan', '=', 'jurusans.id_jurusan')
                    ->leftJoin('fakultas', 'jurusans.id_fakultas', '=', 'fakultas.id_fakultas')
                    ->leftJoin('periodes', 'kelas.id_periode', '=', 'periodes.id_periode')
                    ->where('kelas.id_kelas', $r->id_kelas)
                    ->where('kelas.id_periode', $r->id_periode)
                    ->get();
                return view('pages.nilai.cetak', [
                    'nilai' => $nilai,
                    'periode' => DB::table('periodes')->where('id_periode', $r->id_periode)->first(),
                    'ket1' => 'Nama Kelas',
                    'val1' => DB::table('kelas')
                        ->where('id_kelas', $r->id_kelas)->first()->nama_kelas,

                    'ket2' => 'Dosen',
                    'val2' => DB::table('kelas')
                        ->leftJoin('dosens', 'kelas.nip', '=', 'dosens.nip')
                        ->where('kelas.id_kelas', $r->id_kelas)
                        ->first()->nama_dosen,
                    'ket3' => 'Jumlah Mahasiswa',
                    'val3' => DB::table('nilai_mentorings')
                        ->leftJoin('mahasiswas', 'nilai_mentorings.nim', '=', 'mahasiswas.nim')
                        ->leftJoin('detail_kelas', 'mahasiswas.nim', '=', 'detail_kelas.nim')
                        ->leftJoin('kelas', 'detail_kelas.id_kelas', '=', 'kelas.id_kelas')
                        ->where('detail_kelas.id_kelas', $r->id_kelas)->count(),
                ]);
            }
        }elseif($key == 'fakultas'){
            if($r->id_fakultas){
                $nilai = DB::table('nilai_mentorings')
                    ->leftJoin('mahasiswas', 'nilai_mentorings.nim', '=', 'mahasiswas.nim')
                    ->leftJoin('detail_kelas', 'mahasiswas.nim', '=', 'detail_kelas.nim')
                    ->leftJoin('kelas', 'detail_kelas.id_kelas', '=', 'kelas.id_kelas')
                    ->leftJoin('jurusans', 'mahasiswas.id_jurusan', '=', 'jurusans.id_jurusan')
                    ->leftJoin('fakultas', 'jurusans.id_fakultas', '=', 'fakultas.id_fakultas')
                    ->leftJoin('detail_mentees', 'mahasiswas.nim', '=', 'detail_mentees.nim')
                    ->leftJoin('kelompoks', 'detail_mentees.id_kel', '=', 'kelompoks.id_kel')
                    ->where('fakultas.id_fakultas', $r->id_fakultas)
                    ->where('kelompoks.id_periode', $r->id_periode)
                    ->get();
                return view('pages.nilai.cetak', [
                    'nilai' => $nilai,
                    'periode' => DB::table('periodes')->where('id_periode', $r->id_periode)->first(),
                    'ket1' => 'Nama Fakultas',
                    'val1' => DB::table('fakultas')->where('fakultas.id_fakultas', $r->id_fakultas)->first()->nama_fakultas,
                    'ket2' => 'Jumlah Mahasiswa',
                    'val2' => DB::table('nilai_mentorings')
                        ->leftJoin('mahasiswas', 'nilai_mentorings.nim', '=', 'mahasiswas.nim')
                        ->leftJoin('jurusans', 'mahasiswas.id_jurusan', '=', 'jurusans.id_jurusan')
                        ->leftJoin('fakultas', 'jurusans.id_fakultas', '=', 'fakultas.id_fakultas')
                        ->where('jurusans.id_fakultas', $r->id_fakultas)->count(),
                ]);
            }
        }if($key == 'kelompok'){
            if($r->id_kel){
                $nilai = DB::table('nilai_mentorings')
                    ->leftJoin('mahasiswas', 'nilai_mentorings.nim', '=', 'mahasiswas.nim')
                    ->leftJoin('detail_kelas', 'mahasiswas.nim', '=', 'detail_kelas.nim')
                    ->leftJoin('kelas', 'detail_kelas.id_kelas', '=', 'kelas.id_kelas')
                    ->leftJoin('jurusans', 'mahasiswas.id_jurusan', '=', 'jurusans.id_jurusan')
                    ->leftJoin('fakultas', 'jurusans.id_fakultas', '=', 'fakultas.id_fakultas')
                    ->leftJoin('detail_mentees', 'mahasiswas.nim', '=', 'detail_mentees.nim')
                    ->leftJoin('kelompoks', 'detail_mentees.id_kel', '=', 'kelompoks.id_kel')
                    ->where('kelompoks.id_kel', $r->id_kel)
                    ->where('kelompoks.id_periode', $r->id_periode)
                    ->get();
                return view('pages.nilai.cetak', [
                    'nilai' => $nilai,
                    'periode' => DB::table('periodes')->where('id_periode', $r->id_periode)->first(),
                    'ket1' => 'Nama Kelompok',
                    'val1' => DB::table('kelompoks')->where('id_kel', $r->id_kel)->first()->nama_kel,
                    'mentor' => DB::table('detail_mentors')
                        ->leftJoin('mahasiswas', 'detail_mentors.nim', '=', 'mahasiswas.nim')
                        ->leftJoin('kelompoks', 'detail_mentors.id_kel', '=', 'kelompoks.id_kel')
                        ->where('detail_mentors.id_kel', $r->id_kel)
                        ->get(),
                    'ket2' => 'Jumlah Mahasiswa',
                    'val2' => DB::table('nilai_mentorings')
                        ->leftJoin('mahasiswas', 'nilai_mentorings.nim', '=', 'mahasiswas.nim')
                        ->leftJoin('detail_mentees', 'mahasiswas.nim', '=', 'detail_mentees.nim')
                        ->leftJoin('kelompoks', 'detail_mentees.id_kel', '=', 'kelompoks.id_kel')
                        ->where('kelompoks.id_kel', $r->id_kel)
                        ->count(),

                ]);
            }
        }        
    }
}
