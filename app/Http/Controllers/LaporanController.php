<?php

namespace App\Http\Controllers;

use App\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use File;

class LaporanController extends Controller
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
        
        return view('pages.laporan.index', compact('periode', 'selectedPeriode'), [
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
        // $laporan = DB::table('laporans')
        //     ->leftJoin('pertemuans', 'laporans.id_pertemuan', '=', 'pertemuans.id_pertemuan')
        //     ->leftJoin('mahasiswas', 'laporans.nim', '=', 'mahasiswas.nim')
        //     ->leftJoin('detail_mentors', 'mahasiswas.nim', '=', 'detail_mentors.nim')
        //     ->leftJoin('kelompoks', 'detail_mentors.id_kel', '=', 'kelompoks.id_kel')
        //     ->leftJoin('periodes', 'kelompoks.id_periode', '=', 'periodes.id_periode')
        //     ->select('mahasiswas.*', 
        //         'laporans.*', 
        //         'pertemuans.*',
        //         'mahasiswas.*',
        //         'detail_mentors.*',
        //         'kelompoks.*',
        //         'periodes.*')
        //     ->where('laporans.nim', session('nip_nim'))
        //     ->get();

        // $data = [];
        // foreach ($laporan as $key => $value) {
        //     $data[] = $value->nim;
        // }

        $mentor = DB::table('detail_mentors')
            ->leftJoin('mahasiswas', 'detail_mentors.nim', '=', 'mahasiswas.nim')
            ->leftJoin('kelompoks', 'detail_mentors.id_kel', '=', 'kelompoks.id_kel')
            ->where('mahasiswas.nim', session('nip_nim'))->first();
        // $m = DB::table('mahasiswas')
        //     ->where('nim', $mentor->nim)->get();
        $max = DB::table('detail_mentors')
            ->leftJoin('kelompoks', 'detail_mentors.id_kel', '=', 'kelompoks.id_kel')
            ->leftJoin('periodes', 'kelompoks.id_periode', '=', 'periodes.id_periode')
            ->where('detail_mentors.nim', $mentor->nim)
            ->max('periodes.id_periode');
        $periode = DB::table('periodes')
            ->where('periodes.id_periode', $max)
            ->get();
        $kelompok = DB::table('kelompoks')
            ->leftJoin('detail_mentors', 'kelompoks.id_kel', '=', 'detail_mentors.id_kel')
            ->select('kelompoks.id_kel', 'kelompoks.nama_kel')
            ->where('detail_mentors.nim', $mentor->nim)
            ->where('kelompoks.id_periode', $max)
            ->get();
        $pertemuan = DB::table('pertemuans')
            ->leftJoin('laporans', 'pertemuans.id_pertemuan', '=', 'laporans.id_pertemuan')
            ->leftJoin('kelompoks', 'laporans.id_kel', '=', 'kelompoks.id_kel')
            ->leftJoin('periodes', 'kelompoks.id_periode', '=', 'periodes.id_periode')
            ->where('kelompoks.id_periode', $max)
            ->select('laporans.id_pertemuan')
            ->get();

        return view('pages.laporan.create', [
            "mentor" => $mentor,
            "kelompok" => $kelompok,
            "periode" => $periode,
            "pertemuan" => $pertemuan
        ]);
    }

    public function dropdown(Request $r) //method untuk menampilkan view cetak
    {
        $id_kel = $r->id_kel;

        $mentor = DB::table('detail_mentors')
        ->leftJoin('mahasiswas', 'detail_mentors.nim', '=', 'mahasiswas.nim')
        ->leftJoin('kelompoks', 'detail_mentors.id_kel', '=', 'kelompoks.id_kel')
        ->where('mahasiswas.nim', session('nip_nim'))->first();

        $mentee = DB::table('detail_mentees')
            ->leftJoin('kelompoks', 'detail_mentees.id_kel', 'kelompoks.id_kel')
            ->leftJoin('detail_mentors', 'kelompoks.id_kel', '=', 'detail_mentors.id_kel')
            ->select('detail_mentees.nim')
            ->where('detail_mentors.nim', $mentor->nim)
            ->where('kelompoks.id_kel', $id_kel)
            ->get();
            
        $data = [
            'pesan' => 'ok',
            'mentee' => $mentee
        ];
        return response()->json($data);
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

    public function submit(Request $request)
    {
        $request->validate([
            'nim' => 'required',
            'id_pertemuan' => 'required',   
            'id_kel' => 'required',         
            'tgl' => 'required',
            'laporan' => 'required',
            'keterangan' => 'required',
            'mentee_hadir' => 'required',
            'gambar' => 'mimes:jpeg,gif,tiff,png,bmp,svg'
        ]);

        $gambarName = null;

        if ($request->gambar) {
            $gambarName = $request->gambar->getClientOriginalName() . '-' . time() . '.'
                . $request->gambar->extension();
            $request->gambar->move(public_path('gambar'), $gambarName);
        }

        DB::table('laporans')->insert([
            'nim' => $request->nim,
            'id_pertemuan' => $request->id_pertemuan,
            'id_kel' => $request->id_kel, 
            'tgl' => $request->tgl,     
            'laporan' => $request->laporan,
            'keterangan' => $request->keterangan,
            'mentee_hadir' => $request->mentee_hadir,
            'gambar' => $gambarName
        ]);

        $id_periode = $request->id_periode;

        return redirect()->route('laporan', ['id_periode'=>$id_periode])->with('pesan', 'Laporan berhasil ditambah');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Laporan  $laporan
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = DB::table('laporans')
            ->leftJoin('pertemuans', 'laporans.id_pertemuan', '=', 'pertemuans.id_pertemuan')
            ->leftJoin('mahasiswas', 'laporans.nim', '=', 'mahasiswas.nim')
            ->leftJoin('detail_mentors', 'mahasiswas.nim', '=', 'detail_mentors.nim')
            ->leftJoin('kelompoks', 'laporans.id_kel', '=', 'kelompoks.id_kel')
            ->leftJoin('periodes', 'kelompoks.id_periode', '=', 'periodes.id_periode')
            ->select('mahasiswas.*', 
                'laporans.*', 
                'pertemuans.*',
                'mahasiswas.*',
                'detail_mentors.*',
                'kelompoks.*',
                'periodes.*')
            ->where('laporans.id_laporan', $id)
            ->first();       

        return view('pages.laporan.detail', [
            "items" => $item
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Laporan  $laporan
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {        
        $laporan = DB::table('laporans')
            ->leftJoin('pertemuans', 'laporans.id_pertemuan', '=', 'pertemuans.id_pertemuan')
            ->leftJoin('mahasiswas', 'laporans.nim', '=', 'mahasiswas.nim')
            ->leftJoin('detail_mentors', 'mahasiswas.nim', '=', 'detail_mentors.nim')
            ->leftJoin('kelompoks', 'laporans.id_kel', '=', 'kelompoks.id_kel')
            ->leftJoin('periodes', 'kelompoks.id_periode', '=', 'periodes.id_periode')
            ->select('mahasiswas.*', 
                'laporans.*', 
                'pertemuans.*',
                'mahasiswas.*',
                'detail_mentors.*',
                'kelompoks.*',
                'periodes.*')
            ->where('id_laporan', $id)->first();
        
        $mentor = DB::table('detail_mentors')
            ->leftJoin('mahasiswas', 'detail_mentors.nim', '=', 'mahasiswas.nim')
            ->leftJoin('kelompoks', 'detail_mentors.id_kel', '=', 'kelompoks.id_kel')
            ->where('mahasiswas.nim', session('nip_nim'))->first();
        $max = DB::table('detail_mentors')
            ->leftJoin('kelompoks', 'detail_mentors.id_kel', '=', 'kelompoks.id_kel')
            ->leftJoin('periodes', 'kelompoks.id_periode', '=', 'periodes.id_periode')
            ->where('detail_mentors.nim', $mentor->nim)
            ->max('periodes.id_periode');
        $periode = DB::table('periodes')
            ->where('periodes.id_periode', $max)
            ->get();
        $kelompok = DB::table('kelompoks')
            ->leftJoin('detail_mentors', 'kelompoks.id_kel', '=', 'detail_mentors.id_kel')
            ->leftJoin('periodes', 'kelompoks.id_periode', '=', 'periodes.id_periode')
            ->select('kelompoks.id_kel', 'kelompoks.nama_kel')
            ->where('detail_mentors.nim', $mentor->nim)
            ->where('kelompoks.id_periode', $max)
            ->get();
        $single_kelompok = DB::table('kelompoks')
            ->leftJoin('laporans', 'kelompoks.id_kel', '=', 'laporans.id_kel')
            ->where('laporans.mentee_hadir', $laporan->mentee_hadir)
            ->select('kelompoks.id_kel', 'kelompoks.nama_kel')
            ->first();
        $mentee = DB::table('detail_mentees')
            ->leftJoin('kelompoks', 'detail_mentees.id_kel', 'kelompoks.id_kel')            
            ->where('detail_mentees.id_kel', $single_kelompok->id_kel)
            ->select('detail_mentees.nim')
            ->get();
        return view('pages.laporan.edit', [
            "laporan" => $laporan,
            "periode" => $periode,
            "kelompok" => $kelompok,
            "single_kelompok" => $single_kelompok,
            "mentee" => $mentee
        ]);

        return redirect()->route('laporan');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Laporan  $laporan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_periode' => 'required',
            'id_pertemuan' => 'required',
            'id_kel' => 'required',
            'laporan' => 'required',
            'keterangan' => 'required',
            'tgl' => 'required',
            'mentee_hadir' => 'required',
            'gambar' => 'mimes:jpeg,gif,tiff,png,bmp,svg'
        ]);

        $gambarName = $request->gambarOld;
        if ($request->gambar) {
            $gambarName = $request->gambar->getClientOriginalName() . '-' . time() . '.'
                . $request->gambar->extension();

            $data = DB::table('laporans')->where('id_laporan', $id)->first();
            File::delete(public_path() . '/gambar/' . $data->gambar);
            $request->gambar->move(public_path('gambar'), $gambarName);
        }

        DB::table('laporans')->where('id_laporan', $id)->update([
            'id_pertemuan' => $request->id_pertemuan,
            'id_kel' => $request->id_kel,
            'laporan' => $request->laporan,
            'keterangan' => $request->keterangan,
            'tgl' => $request->tgl,
            'mentee_hadir' => $request->mentee_hadir,
            'gambar' => $gambarName
        ]);
        $id_periode = $request->id_periode;

        return redirect()->route('laporan', ['id_periode'=>$id_periode])->with('pesan', 'Laporan berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Laporan  $laporan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Laporan $laporan)
    {
        //
    }

    public function delete($id)
    {
        DB::table('laporans')->where('id_laporan', $id)->delete();

        return redirect()->back()->with('pesan', 'Laporan berhasil dihapus');
    }
}
