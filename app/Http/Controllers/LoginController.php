<?php

namespace App\Http\Controllers;

use App\Helper\JwtHelper;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index()
    {
        return view('pages.login.index');
    }

    public function submit(Request $request)
    {
        $user = new User();
        $data_user = $user->checkLogin($request->input("nip_nim"), $request->input('password'));
        if ($data_user) {
            $token = JwtHelper::BuatToken($data_user);

            $request->session()->put('nama', $data_user->name);
            $request->session()->put('nip_nim', $data_user->nip_nim);
            $request->session()->put('id_role', $data_user->id_role);
            $request->session()->put('token', $token);

            return redirect('/')->with("pesan", "Selamat Datang " . session('nama'));
        } else {
            return back()->with("error", "Nip/Nim atau Password Salah!");
        }
    }

    public function logout(Request $request)
    {
        $request->session()->forget('nama');
        $request->session()->forget('nip_nim');
        $request->session()->forget('id_role');
        $request->session()->forget('token');

        return redirect('/login')->with("pesan", "Anda Sudah Logout");
    }

    public function reset()
    {
        return view('pages.login.reset');
    }

    public function api_reset(Request $r)
    {
        $nip_nim = $r->nip_nim;
        $user = DB::table('users')
            ->where('nip_nim', $nip_nim)
            ->first();
        $data = [
            'pesan' => 'ok',
            'user' => $user,
        ];

        return response()->json($data);
    }

    public function reset_password(Request $r)
    {
        DB::table('users')->where('nip_nim', $r->nip_nim)->update([
            'password' => Hash::make($r->password),
        ]);

        return redirect()->back()->with('pesan', 'Password berhasil diubah');
    }
}
