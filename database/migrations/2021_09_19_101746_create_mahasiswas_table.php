<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMahasiswasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mahasiswas', function (Blueprint $table) {
            $table->bigIncrements('nim', 30);            
            $table->string('id_jurusan', 20);
            $table->string('nama_mhs', 50);
            $table->string('jenis_kelamin', 20);
            $table->string('tempat_lahir', 100);
            $table->date('tgl_lahir', 20);
            $table->string('alamat', 100);
            $table->string('no_hp', 20);
            $table->string('email', 40);
            $table->string('gol_dar', 10);
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
        Schema::dropIfExists('mahasiswas');
    }
}
