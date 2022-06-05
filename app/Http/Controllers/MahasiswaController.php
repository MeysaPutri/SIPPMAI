<?php

namespace App\Http\Controllers;

use App\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mahasiswa = DB::table('mahasiswas')
            ->leftJoin('users', 'mahasiswas.nim', '=', 'users.nip_nim')
            ->leftJoin('jurusans', 'mahasiswas.id_jurusan', '=', 'jurusans.id_jurusan')
            ->leftJoin('fakultas', 'jurusans.id_fakultas', '=', 'fakultas.id_fakultas')
            ->select('users.*', 'mahasiswas.*', 'jurusans.*', 'fakultas.*')
            ->get();

        return view('pages.mahasiswa.index', [
            "mahasiswa" => $mahasiswa
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $mahasiswa = DB::table('mahasiswas')->select('mahasiswas.*')->get();

        return view('pages.mahasiswa.create',[
            "mahasiswa" => $mahasiswa
        ]);
    }
    
    public function submit(Request $request)
    {
        $this->validate($request,[
            'nim' =>'required|unique:mahasiswas',
            'email' =>'required|unique:mahasiswas',
        ]);

        DB::table('users')->insert([
            'nip_nim' => $request->nim,
            'id_role' => NULL,
            'name' => $request->nama_mhs,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status_aktif' => 'aktif'
        ]);

        DB::table('mahasiswas')->insert([
            'nim' => $request->nim,
            'id_jurusan' => $request->id_jurusan,
            'nama_mhs' => $request->nama_mhs,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir' => $request->tempat_lahir,
            'tgl_lahir' => $request->tgl_lahir,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
            'email' => $request->email,
            'gol_dar' => $request->gol_dar
        ]);
 
        return redirect()->route('mahasiswa')->with('pesan', 'Data mahasiswa berhasil ditambah');
    }

    public function delete($id)
    {
        DB::table('mahasiswas')->where('nim', $id)->delete();
        DB::table('users')->where('nip_nim', $id)->delete();
        DB::table('detail_mentees')->where('nim', $id)->delete();
        DB::table('detail_mentors')->where('nim', $id)->delete();
        DB::table('detail_kelas')->where('nim', $id)->delete();
        DB::table('laporans')->where('nim', $id)->delete();
        DB::table('amalan_yaumis')->where('nim', $id)->delete();
        DB::table('nilai_mentorings')->where('nim', $id)->delete();
        DB::table('scms')->where('nim', $id)->delete();

        return redirect()->route('mahasiswa')->with('pesan', 'Data mahasiswa berhasil dihapus');
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
     * @param  \App\Mahasiswa  $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = DB::table('mahasiswas')
            ->leftJoin('jurusans', 'mahasiswas.id_jurusan', '=', 'jurusans.id_jurusan')
            ->leftJoin('fakultas', 'jurusans.id_fakultas', '=', 'fakultas.id_fakultas')
            ->where('mahasiswas.nim', $id)
            ->first();

        return view('pages.mahasiswa.detail', [
            "items" => $item
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Mahasiswa  $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $mahasiswa = DB::table('mahasiswas')
        ->leftJoin('users', 'mahasiswas.nim', '=', 'users.nip_nim')
        ->leftJoin('jurusans', 'mahasiswas.id_jurusan', '=', 'jurusans.id_jurusan')
        ->leftJoin('fakultas', 'jurusans.id_fakultas', '=', 'fakultas.id_fakultas')
        ->select(
            'mahasiswas.*',
            'users.*',
            'jurusans.*',
            'fakultas.*',
            'mahasiswas.email as emailmahasiswa'
        )
        ->where('nim', $id)->first();
    return view('pages.mahasiswa.edit', [
        "mahasiswa" => $mahasiswa
    ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Mahasiswa  $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {    
        DB::table('users')->where('nip_nim', $id)->update([
            'nip_nim' => $request->nim,
            'id_role' => 1,
            'name' => $request->nama_mhs,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status_aktif' => 'aktif'
        ]);

        DB::table('mahasiswas')->where('nim', $id)->update([
            'nim' => $request->nim,
            'id_jurusan' => $request->id_jurusan,
            'nama_mhs' => $request->nama_mhs,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir' => $request->tempat_lahir,
            'tgl_lahir' => $request->tgl_lahir,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
            'email' => $request->email,
            'gol_dar' => $request->gol_dar
        ]);

        return redirect()->route('mahasiswa')->with('pesan', 'Data mahasiswa berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Mahasiswa  $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mahasiswa $mahasiswa)
    {
        //
    }

    public function api_fakultas(Request $request)
    {
        $id_fakultas = $request->id_fakultas;
        $jurusan = DB::table('jurusans')
            ->where('id_fakultas', $id_fakultas)
            ->get();
        $data = [
            'pesan' => 'ok',
            'jurusan' => $jurusan,
        ];
        return response()->json($data);
    }
}
