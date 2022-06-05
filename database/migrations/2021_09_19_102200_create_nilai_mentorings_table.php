<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNilaiMentoringsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nilai_mentorings', function (Blueprint $table) {
            $table->bigIncrements('id_nm', 20);
            $table->string('nim', 20);
            $table->string('hadir', 20);
            $table->string('izin', 20);
            $table->string('alfa', 20);
            $table->string('pertemuan_ujian', 20);
            $table->string('total_kehadiran', 20);
            $table->string('npendalaman_materi', 20)->nullable();
            $table->string('total_pendalaman', 20)->nullable();
            $table->string('baca_alquran',20)->nullable();
            $table->string('hafalan',20)->nullable();
            $table->string('total_bbq', 20)->nullable();
            $table->string('wudu', 20)->nullable();
            $table->string('shalat', 20)->nullable();
            $table->string('total_ibadah', 20)->nullable();
            $table->string('akhlak', 20)->nullable();
            $table->string('total_akhlak', 20)->nullable();
            $table->string('total_nilai', 20);
            $table->string('penilai', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nilai_mentorings');
    }
}
