<?php

use Illuminate\Database\Seeder;

class FakultasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //id_fakultas = 1
        $fe = new \App\Fakultas();
        $fe->nama_fakultas = "Fakultas Ekonomi";
        $fe->save();

        //id_fakultas = 2
        $fmipa = new \App\Fakultas();
        $fmipa->nama_fakultas = "Fakultas MIPA";
        $fmipa->save();

        //id_fakultas = 3
        $faperta = new \App\Fakultas();
        $faperta ->nama_fakultas = "Fakultas Pertanian";
        $faperta ->save();

        //id_fakultas = 4
        $faterna = new \App\Fakultas();
        $faterna->nama_fakultas = "Fakultas Peternakan";
        $faterna->save();

        //id_fakultas = 5
        $ft = new \App\Fakultas();
        $ft->nama_fakultas = "Fakultas Teknik";
        $ft->save();

        //id_fakultas = 6
        $fti = new \App\Fakultas();
        $fti->nama_fakultas = "Fakultas Teknologi Informasi";
        $fti->save();

        //id_fakultas = 7
        $ftp = new \App\Fakultas();
        $ftp->nama_fakultas = "Fakultas Teknologi Pertanian";
        $ftp->save();

        //id_fakultas = 8
        $ff = new \App\Fakultas();
        $ff->nama_fakultas = "Fakultas Farmasi";
        $ff->save();

        //id_fakultas = 9
        $fh = new \App\Fakultas();
        $fh->nama_fakultas = "Fakultas Hukum";
        $fh->save();

        //id_fakultas = 10
        $fib = new \App\Fakultas();
        $fib->nama_fakultas = "Fakultas Ilmu Budaya";
        $fib->save();

        //id_fakultas = 11
        $fisip = new \App\Fakultas();
        $fisip->nama_fakultas = "Fakultas Ilmu Sosial dan Ilmu Politik";
        $fisip->save();

        //id_fakultas = 12
        $fk = new \App\Fakultas();
        $fk->nama_fakultas = "Fakultas Kedokteran";
        $fk->save();

        //id_fakultas = 13
        $fkg = new \App\Fakultas();
        $fkg->nama_fakultas = "Fakultas Kedokteran Gigi";
        $fkg->save();

        //id_fakultas = 14
        $fkep = new \App\Fakultas();
        $fkep->nama_fakultas = "Fakultas Keperawatan";
        $fkep->save();

        //id_fakultas = 15
        $fkesmas = new \App\Fakultas();
        $fkesmas->nama_fakultas = "Fakultas Kesehatan Masyarakat";
        $fkesmas->save();
    }
}
