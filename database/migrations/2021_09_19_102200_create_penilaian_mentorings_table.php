<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenilaianMentoringsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penilaian_mentorings', function (Blueprint $table) {
            $table->bigIncrements('id_pm');
            $table->string('id_mentor_mentee');
            $table->string('kehadiran');
            $table->string('npendalaman_materi');
            $table->string('baca_alquran');
            $table->string('hafalan');
            $table->string('wudu');
            $table->string('shalat');
            $table->string('akhlak');
            $table->string('total_nilai');
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
        Schema::dropIfExists('penilaian_mentorings');
    }
}
