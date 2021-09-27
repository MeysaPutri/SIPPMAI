<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmalanYaumisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amalan_yaumis', function (Blueprint $table) {
            $table->bigIncrements('id_ay');
            $table->string('id_mentor_mentee');
            $table->string('pertemuan_ke');
            $table->string('kehadiran');
            $table->string('qiyamullail');
            $table->string('shaum_nawafil');
            $table->string('tilawah_alquran');
            $table->string('hafalan_juz');
            $table->string('wirid_matsurat');
            $table->string('shalat_dhuha');
            $table->string('shalat_berjamaah');
            $table->string('membaca_buku_islami');
            $table->string('riyadhoh');
            $table->string('infak');
            $table->string('agenda_ukhwah');
            $table->string('shalat_rawatib');
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
        Schema::dropIfExists('amalan_yaumis');
    }
}
