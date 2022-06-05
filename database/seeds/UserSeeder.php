<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new \App\User();
        $user->nip_nim = 1;
        $user->id_role = 4;
        $user->name = 'Administrator';
        $user->password = Hash::make('admin');
        $user->status_aktif = 'aktif';
        $user->save();
    }
}
