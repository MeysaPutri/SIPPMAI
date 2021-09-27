<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mentor = new \App\Role();
        $mentor->nama_role = "mentor";
        $mentor->save();

        $dosen = new \App\Role();
        $dosen->nama_role = "dosen";
        $dosen->save();

        $mentee = new \App\Role();
        $mentee->nama_role = "mentee";
        $mentee->save();

        $admin = new \App\Role();
        $admin->nama_role = "admin";
        $admin->save();
    }
}
