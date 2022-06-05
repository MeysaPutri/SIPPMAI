<?php

use Illuminate\Database\Seeder;

class JurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $d_akun = new \App\Jurusan();
        $d_akun->id_fakultas = 1;
        $d_akun->nama_jurusan = "D3 - Akuntansi";
        $d_akun->save();

        $d_sek = new \App\Jurusan();
        $d_sek->id_fakultas = 1;
        $d_sek->nama_jurusan = "D3 - Kesekretariatan";
        $d_sek->save();

        $d_keu = new \App\Jurusan();
        $d_keu->id_fakultas = 1;
        $d_keu->nama_jurusan = "D3 - Keuangan";
        $d_keu->save();

        $d_mp = new \App\Jurusan();
        $d_mp->id_fakultas = 1;
        $d_mp->nama_jurusan = "D3 - Manajemen Pemasaran";
        $d_mp->save();

        $akun = new \App\Jurusan();
        $akun->id_fakultas = 1;
        $akun->nama_jurusan = "S1 - Akuntansi";
        $akun->save();

        $ep = new \App\Jurusan();
        $ep->id_fakultas = 1;
        $ep->nama_jurusan = "S1 - Ekonomi Pembangunan";
        $ep->save();

        $epkp = new \App\Jurusan();
        $epkp->id_fakultas = 1;
        $epkp->nama_jurusan = "S1 - Ekonomi Pembangunan (Kampus Payakumbuh)";
        $epkp->save();

        $m = new \App\Jurusan();
        $m->id_fakultas = 1;
        $m->nama_jurusan = "S1 - Manajemen";
        $m->save();

        $mkp = new \App\Jurusan();
        $mkp->id_fakultas = 1;
        $mkp->nama_jurusan = "S1 - Manajemen (Kampus Payakumbuh)";
        $mkp->save();

        $f = new \App\Jurusan();
        $f->id_fakultas = 8;
        $f->nama_jurusan = "S1 - Farmasi";
        $f->save();

        $ih = new \App\Jurusan();
        $ih->id_fakultas = 9;
        $ih->nama_jurusan = "S1 - Ilmu Hukum";
        $ih->save();

        $is = new \App\Jurusan();
        $is->id_fakultas = 10;
        $is->nama_jurusan = "S1 - Ilmu Sejarah";
        $is->save();

        $sindo = new \App\Jurusan();
        $sindo->id_fakultas = 10;
        $sindo->nama_jurusan = "S1 - Sastra Indonesia";
        $sindo->save();

        $sasing = new \App\Jurusan();
        $sasing->id_fakultas = 10;
        $sasing->nama_jurusan = "S1 - Sastra Inggris";
        $sasing->save();

        $sajeng = new \App\Jurusan();
        $sajeng->id_fakultas = 10;
        $sajeng->nama_jurusan = "S1 - Sastra Jepang";
        $sajeng->save();

        $sm = new \App\Jurusan();
        $sm->id_fakultas = 10;
        $sm->nama_jurusan = "S1 - Sastra Minangkabau";
        $sm->save();

        $as = new \App\Jurusan();
        $as->id_fakultas = 11;
        $as->nama_jurusan = "S1 - Antropologi Sosial";
        $as->save();

        $iap = new \App\Jurusan();
        $iap->id_fakultas = 11;
        $iap->nama_jurusan = "S1 - Ilmu Administrasi Publik";
        $iap->save();

        $ihi = new \App\Jurusan();
        $ihi->id_fakultas = 11;
        $ihi->nama_jurusan = "S1 - Ilmu Hubungan Internasional";
        $ihi->save();

        $ik = new \App\Jurusan();
        $ik->id_fakultas = 11;
        $ik->nama_jurusan = "S1 - Ilmu Komunikasi";
        $ik->save();

        $ip = new \App\Jurusan();
        $ip->id_fakultas = 11;
        $ip->nama_jurusan = "S1 - Ilmu Politik";
        $ip->save();

        $sosio = new \App\Jurusan();
        $sosio->id_fakultas = 11;
        $sosio->nama_jurusan = "S1 - Sosiologi";
        $sosio->save();

        $keb = new \App\Jurusan();
        $keb->id_fakultas = 12;
        $keb->nama_jurusan = "S1 - Kebidanan";
        $keb->save();

        $k = new \App\Jurusan();
        $k->id_fakultas = 12;
        $k->nama_jurusan = "S1 - Kedokteran";
        $k->save();

        $ps = new \App\Jurusan();
        $ps->id_fakultas = 12;
        $ps->nama_jurusan = "S1 - Psikologi";
        $ps->save();

        $pkg = new \App\Jurusan();
        $pkg->id_fakultas = 13;
        $pkg->nama_jurusan = "S1 - Pendidikan Dokter Gigi";
        $pkg->save();

        $ikep = new \App\Jurusan();
        $ikep->id_fakultas = 14;
        $ikep->nama_jurusan = "S1 - Ilmu Keperawatan";
        $ikep->save();

        $kesmas = new \App\Jurusan();
        $kesmas->id_fakultas = 15;
        $kesmas->nama_jurusan = "S1 - Kesehatan Masyarakat";
        $kesmas->save();

        $g = new \App\Jurusan();
        $g->id_fakultas = 15;
        $g->nama_jurusan = "S1 - Gizi";
        $g->save();

        $b = new \App\Jurusan();
        $b->id_fakultas = 2;
        $b->nama_jurusan = "S1 - Biologi";
        $b->save();

        $fisik = new \App\Jurusan();
        $fisik->id_fakultas = 2;
        $fisik->nama_jurusan = "S1 - Fisika";
        $fisik->save();

        $kimia = new \App\Jurusan();
        $kimia->id_fakultas = 2;
        $kimia->nama_jurusan = "S1 - Kimia";
        $kimia->save();

        $mtk = new \App\Jurusan();
        $mtk->id_fakultas = 2;
        $mtk->nama_jurusan = "S1 - Matematika";
        $mtk->save();

        $agri = new \App\Jurusan();
        $agri->id_fakultas = 3;
        $agri->nama_jurusan = "S1 - Agribisnis";
        $agri->save();

        $agrokp = new \App\Jurusan();
        $agrokp->id_fakultas = 3;
        $agrokp->nama_jurusan = "S1 - Agroekoteknologi, Kampus Dharmasraya";
        $agrokp->save();

        $agro = new \App\Jurusan();
        $agro->id_fakultas = 3;
        $agro->nama_jurusan = "S1 - Agroekoteknologi";
        $agro->save();

        $it = new \App\Jurusan();
        $it->id_fakultas = 3;
        $it->nama_jurusan = "S1 - Ilmu Tanah";
        $it->save();

        $pp = new \App\Jurusan();
        $pp->id_fakultas = 3;
        $pp->nama_jurusan = "S1 - Penyuluhan Pertanian";
        $pp->save();

        $pt = new \App\Jurusan();
        $pt->id_fakultas = 3;
        $pt->nama_jurusan = "S1 - Proteksi Tanaman";
        $pt->save();

        $ternak = new \App\Jurusan();
        $ternak->id_fakultas = 4;
        $ternak->nama_jurusan = "S1 - Peternakan";
        $ternak->save();

        $ternakkp = new \App\Jurusan();
        $ternakkp->id_fakultas = 4;
        $ternakkp->nama_jurusan = "S1 - Peternakan, Kampus Payakumbuh";
        $ternakkp->save();

        $te = new \App\Jurusan();
        $te->id_fakultas = 5;
        $te->nama_jurusan = "S1 - Teknik Elektro";
        $te->save();

        $ti = new \App\Jurusan();
        $ti->id_fakultas = 5;
        $ti->nama_jurusan = "S1 - Teknik Industri";
        $ti->save();

        $tl = new \App\Jurusan();
        $tl->id_fakultas = 5;
        $tl->nama_jurusan = "S1 - Teknik Lingkungan";
        $tl->save();

        $tm = new \App\Jurusan();
        $tm->id_fakultas = 5;
        $tm->nama_jurusan = "S1 - Teknik Mesin";
        $tm->save();

        $ts = new \App\Jurusan();
        $ts->id_fakultas = 5;
        $ts->nama_jurusan = "S1 - Teknik Sipil";
        $ts->save();

        $si = new \App\Jurusan();
        $si->id_fakultas = 6;
        $si->nama_jurusan = "S1 - Sistem Informasi";
        $si->save();

        $tk = new \App\Jurusan();
        $tk->id_fakultas = 6;
        $tk->nama_jurusan = "S1 - Teknik Komputer";
        $tk->save();

        $tp = new \App\Jurusan();
        $tp->id_fakultas = 7;
        $tp->nama_jurusan = "S1 - Teknik Pertanian";
        $tp->save();

        $thp = new \App\Jurusan();
        $thp->id_fakultas = 7;
        $thp->nama_jurusan = "S1 - Teknologi Hasil Pertanian";
        $thp->save();

        $tip = new \App\Jurusan();
        $tip->id_fakultas = 7;
        $tip->nama_jurusan = "S1 - Teknologi Industri Pertanian";
        $tip->save();

        $bio = new \App\Jurusan();
        $bio->id_fakultas = 12;
        $bio->nama_jurusan = "S1 - Ilmu Biomedis";
        $bio->save();
    }
}
