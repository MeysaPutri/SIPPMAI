<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaporansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laporans', function (Blueprint $table) {
            $table->bigIncrements('id_laporan', 20);            
            $table->string('nim', 20);
            $table->string('id_pertemuan', 20); 
            $table->date('tgl', 20);  
            $table->string('id_kel', 20);  
            $table->string('laporan', 100);
            $table->string('keterangan', 100);            
            $table->string('mentee_hadir', 20);
            $table->string('gambar', 1000);
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
        Schema::dropIfExists('laporans');
    }
}
