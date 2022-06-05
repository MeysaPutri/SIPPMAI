<?php

namespace App\Http\Controllers;

use App\DetailMentee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DetailMenteeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $kelompok = DB::table('kelompoks')->where('id_kel', $id)->first();

        $mentee = DB::table('detail_mentees')
            ->leftJoin('kelompoks', 'detail_mentees.id_kel', '=', 'kelompoks.id_kel')
            ->leftJoin('mahasiswas', 'detail_mentees.nim', '=', 'mahasiswas.nim')
            ->leftJoin('detail_kelas', 'mahasiswas.nim', '=', 'detail_kelas.nim')
            ->leftJoin('kelas', 'detail_kelas.id_kelas', '=', 'kelas.id_kelas')
            ->leftJoin('dosens', 'kelas.nip', '=', 'dosens.nip')
            ->leftJoin('jurusans', 'mahasiswas.id_jurusan', '=', 'jurusans.id_jurusan')
            ->where('kelompoks.id_kel', $id)
            ->select(
                'detail_mentees.id_mentee',
                'kelompoks.nama_kel',
                'mahasiswas.nama_mhs',
                'mahasiswas.nim',
                'jurusans.nama_jurusan',
                'mahasiswas.no_hp',
                'detail_mentees.nim',
                'kelas.nama_kelas',
                'dosens.nama_dosen',
                'kelas.sks'
            )
            ->get();

        $mentor = DB::table('detail_mentors')
            ->leftJoin('mahasiswas', 'detail_mentors.nim', '=', 'mahasiswas.nim')
            ->where('detail_mentors.id_kel', $id)
            ->get();

        return view('pages.detail_mentee.index', [
            "mentee" => $mentee,
            "id_kelompok" => $id,
            "kelompok" => $kelompok,
            "mentor" => $mentor,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $detail_mentee = DB::table('detail_mentees')->select('nim')->get();

        $data = [];
        foreach ($detail_mentee as $key => $value) {
            $data[] = $value->nim;
        }
        $kelompok = DB::table('kelompoks')->where('id_kel', $id)->first();
        $mentee = DB::table('mahasiswas')
            ->leftJoin('users', 'mahasiswas.nim', '=', 'users.nip_nim')
            ->where('users.id_role', NULL)
            ->orWhere('users.id_role', 3)
            ->whereNotIn('nim', $data)
            ->select('mahasiswas.nim', 'mahasiswas.nama_mhs', 'users.id_role')
            ->get();

        return view('pages.detail_mentee.create', [
            "id_kelompok" => $id,
            "mentee" => $mentee,
            "kelompok" => $kelompok
        ]);
    }

    public function submit(Request $request, )
    {
        $nim = $request->nim;
        DB::table('users')->where('nip_nim', $nim)->update([
            'id_role' => 3,
            'password' => Hash::make($request->password),
            'status_aktif' => 'aktif'
        ]);

        DB::table('detail_mentees')->insert([
            "id_kel" => $request->id_kel,
            "nim" => $request->nim,
            "created_at" => \Carbon\Carbon::now(),
            "updated_at" => \Carbon\Carbon::now()
        ]);

        //input id_role 3 ->untuk mentee
        // DB::table('users')->where('nip_nim')->update([
        //     'id_role' => 3
        // ]);

        return redirect()->route('detail_mentee', $request->id_kel)->with('pesan', 'Mentee berhasil ditambah');
    }
    
    public function delete($id, $id_kel)
    {
        DB::table('detail_mentees')->where('nim', $id)->delete();
        DB::table('nilai_mentorings')->where('nim', $id)->delete();
        DB::table('amalan_yaumis')->where('nim', $id)->delete();

        return redirect()->route('detail_mentee', $id_kel)->with('pesan', 'Mentee berhasil dihapus');
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
     * @param  \App\DetailMentee  $detailMentee
     * @return \Illuminate\Http\Response
     */
    public function show(DetailMentee $detailMentee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DetailMentee  $detailMentee
     * @return \Illuminate\Http\Response
     */
    public function edit(DetailMentee $detailMentee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DetailMentee  $detailMentee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DetailMentee $detailMentee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DetailMentee  $detailMentee
     * @return \Illuminate\Http\Response
     */
    public function destroy(DetailMentee $detailMentee)
    {
        //
    }
}
