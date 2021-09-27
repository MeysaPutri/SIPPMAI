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
            $table->string('nim');
            $table->string('nama_mhs');
            $table->string('jenis_kelamin');
            $table->string('ttl');
            $table->string('jurusan');
            $table->string('fakultas');
            $table->string('alamat');
            $table->string('no_hp');
            $table->string('email');
            $table->string('gol_dar');
            $table->timestamps();

            $table->primary('nim');
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
