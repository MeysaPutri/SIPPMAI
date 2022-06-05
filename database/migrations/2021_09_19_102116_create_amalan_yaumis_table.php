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
            $table->string('id_pertemuan', 20); 
            $table->string('nim', 20);           
            $table->string('id_aktifitas', 10);
            $table->string('isian', 50);
            $table->string('evaluasi', 100)->nullable();
            $table->string('pengevaluasi', 50)->nullable();
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
