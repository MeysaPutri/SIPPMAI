<?php

use Illuminate\Database\Seeder;

class PertemuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $satu = new \App\Pertemuan();
        $satu->pertemuan = "Satu";
        $satu->save();

        $dua = new \App\Pertemuan();
        $dua->pertemuan = "Dua";
        $dua->save();

        $tiga = new \App\Pertemuan();
        $tiga->pertemuan = "Tiga";
        $tiga->save();

        $empat = new \App\Pertemuan();
        $empat->pertemuan = "Empat";
        $empat->save();

        $lima = new \App\Pertemuan();
        $lima->pertemuan = "Lima";
        $lima->save();

        $enam = new \App\Pertemuan();
        $enam->pertemuan = "Enam";
        $enam->save();

        $tujuh = new \App\Pertemuan();
        $tujuh->pertemuan = "Tujuh";
        $tujuh->save();

        $delapan = new \App\Pertemuan();
        $delapan->pertemuan = "Delapan";
        $delapan->save();

        $sembilan = new \App\Pertemuan();
        $sembilan->pertemuan = "Sembilan";
        $sembilan->save();
    }
}
