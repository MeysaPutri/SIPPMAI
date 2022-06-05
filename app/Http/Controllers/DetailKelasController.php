<?php

namespace App\Http\Controllers;

use App\Detail_Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DetailKelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $kelas = DB::table('kelas')->where('id_kelas', $id)->first();

        $mahasiswa = DB::table('mahasiswas')
            ->leftJoin('detail_mentees', 'mahasiswas.nim', '=', 'detail_mentees.nim')
            ->leftJoin('kelompoks', 'detail_mentees.id_kel', '=', 'kelompoks.id_kel')
            ->leftJoin('detail_kelas', 'mahasiswas.nim', '=', 'detail_kelas.nim')
            ->leftJoin('kelas', 'detail_kelas.id_kelas', '=', 'kelas.id_kelas')
            ->leftJoin('jurusans', 'mahasiswas.id_jurusan', '=', 'jurusans.id_jurusan')
            ->where('kelas.id_kelas', $id)
            ->select(
                'detail_kelas.id_dkelas',
                'kelas.nama_kelas',
                'mahasiswas.nama_mhs',
                'mahasiswas.nim',
                'jurusans.nama_jurusan',
                'mahasiswas.no_hp',
                'kelompoks.nama_kel'
            )
            ->get();

        $dosen = DB::table('dosens')
            ->leftJoin('kelas', 'dosens.nip', '=', 'kelas.nip')
            ->where('kelas.id_kelas', $id)
            ->get();

        return view('pages.detail_kelas.index', [
            "dosen" => $dosen,
            "id_kelas" => $id,
            "kelas" => $kelas,
            "mahasiswa" => $mahasiswa
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $detail_kelas = DB::table('detail_kelas')->select('nim')->get();

        $data = [];
        foreach ($detail_kelas as $key => $value) {
            $data[] = $value->nim;
        }
        $kelas = DB::table('kelas')->where('id_kelas', $id)->first();
        $mahasiswa = DB::table('mahasiswas')
            ->leftJoin('users', 'mahasiswas.nim', '=', 'users.nip_nim')
            ->where('users.id_role', NULL)
            ->orWhere('users.id_role', 3)
            ->whereNotIn('nim', $data)
            ->select('mahasiswas.nim', 'mahasiswas.nama_mhs')
            ->get();

        return view('pages.detail_kelas.create', [
            "id_kelas" => $id,
            "mahasiswa" => $mahasiswa,
            "kelas" => $kelas
        ]);
    }

    public function submit(Request $request)
    {
        DB::table('detail_kelas')->insert([
            "id_kelas" => $request->id_kelas,
            "nim" => $request->nim,
            "created_at" => \Carbon\Carbon::now(),
            "updated_at" => \Carbon\Carbon::now()
        ]);
        return redirect()->route('detail_kelas', $request->id_kelas)->with('pesan', 'Mahasiswa berhasil ditambah');
    }

    public function delete($id, $id_kelas)
    {
        DB::table('detail_kelas')->where('nim', $id)->delete();

        return redirect()->route('detail_kelas', $id_kelas)->with('pesan', 'Mahasiswa berhasil dihapus');
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
     * @param  \App\Detail_Kelas  $detail_Kelas
     * @return \Illuminate\Http\Response
     */
    public function show(Detail_Kelas $detail_Kelas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Detail_Kelas  $detail_Kelas
     * @return \Illuminate\Http\Response
     */
    public function edit(Detail_Kelas $detail_Kelas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Detail_Kelas  $detail_Kelas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Detail_Kelas $detail_Kelas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Detail_Kelas  $detail_Kelas
     * @return \Illuminate\Http\Response
     */
    public function destroy(Detail_Kelas $detail_Kelas)
    {
        //
    }
}
