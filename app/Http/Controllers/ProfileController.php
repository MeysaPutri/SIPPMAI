<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function index()
    {
        return view('pages.profile.index');
    }

    public function update(Request $request)
    {

        $nip_nim = $request->nip_nim;

        if (session('id_role') == 1) {
            //mentor
            DB::table('users')->where('nip_nim', $nip_nim)->update([
                'nip_nim' => $request->nip_nim,
                'name' => $request->name
            ]);
            DB::table('detail_mentors')->where('nim', $nip_nim)->update([
                'nim' => $request->nip_nim
            ]);
            DB::table('mahasiswas')->where('nim', $nip_nim)->update([
                'nim' => $request->nip_nim,
                'nama_mhs' => $request->name,
                'no_hp' => $request->no_hp,
                'email' => $request->email
            ]);
        } elseif (session('id_role') == 2) {
            //dosen
            DB::table('users')->where('nip_nim', $nip_nim)->update([
                'nip_nim' => $request->nip_nim,
                'name' => $request->name
            ]);
            DB::table('dosens')->where('nip', $nip_nim)->update([
                'nip' => $request->nip_nim,
                'nama_dosen' => $request->name,
                'no_hp' => $request->no_hp,
                'email' => $request->email
            ]);
        } elseif (session('id_role') == 3) {
            // mentee
            DB::table('users')->where('nip_nim', $nip_nim)->update([
                'nip_nim' => $request->nip_nim,
                'name' => $request->name
            ]);
            DB::table('detail_mentees')->where('nim', $nip_nim)->update([
                'nim' => $request->nip_nim
            ]);
            DB::table('mahasiswas')->where('nim', $nip_nim)->update([
                'nim' => $request->nip_nim,
                'nama_mhs' => $request->name,
                'no_hp' => $request->no_hp,
                'email' => $request->email
            ]);
        } 
        // elseif (session('id_role') == 4) {
        //     //admin
        //     DB::table('users')->where('nip_nim', $nip_nim)->update([
        //         'nip_nim' => $request->nip_nim,
        //         'name' => $request->name
        //     ]);
        // }
        return redirect()->route('profile')->with('pesan', 'Profile berhasil diubah');
    }
}
