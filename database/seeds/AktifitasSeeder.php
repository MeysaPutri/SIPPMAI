<?php

use Illuminate\Database\Seeder;

class AktifitasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $qiyamullail = new \App\Aktifitas();
        $qiyamullail->nama_aktifitas = "Qiyamullail";
        $qiyamullail->save();

        $shaum = new \App\Aktifitas();
        $shaum->nama_aktifitas = "Shaum nawafil";
        $shaum->save();

        $tilawah = new \App\Aktifitas();
        $tilawah->nama_aktifitas = "Tilawah quran";
        $tilawah->save();

        $hafalan = new \App\Aktifitas();
        $hafalan->nama_aktifitas = "Hafalan juz 30";
        $hafalan->save();

        $wirid = new \App\Aktifitas();
        $wirid->nama_aktifitas = "Wirid matsurat";
        $wirid->save();

        $dhuha = new \App\Aktifitas();
        $dhuha->nama_aktifitas = "Shalat dhuha";
        $dhuha->save();

        $berjamaah = new \App\Aktifitas();
        $berjamaah->nama_aktifitas = "Shalat berjamaah di masjid";
        $berjamaah->save();

        $membaca = new \App\Aktifitas();
        $membaca->nama_aktifitas = "Membaca buku islami";
        $membaca->save();

        $riyadhoh = new \App\Aktifitas();
        $riyadhoh->nama_aktifitas = "Riyadhoh";
        $riyadhoh->save();

        $infak = new \App\Aktifitas();
        $infak->nama_aktifitas = "Infak";
        $infak->save();

        $ukhwah = new \App\Aktifitas();
        $ukhwah->nama_aktifitas = "Agenda ukhwah";
        $ukhwah->save();

        $rawatib = new \App\Aktifitas();
        $rawatib->nama_aktifitas = "Sholat rawatib";
        $rawatib->save();
    }
}
