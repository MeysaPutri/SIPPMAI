<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKelompokMahasiswasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kelompok_mahasiswas', function (Blueprint $table) {
            $table->bigIncrements('id_mentor_mentee');
            $table->string('id_kel');
            $table->string('id_mentor');
            $table->string('id_mentee');
            $table->string('nip_nim');
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
        Schema::dropIfExists('kelompok_mahasiswas');
    }
}
