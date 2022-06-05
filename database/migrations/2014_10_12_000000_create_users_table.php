<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('nip_nim', 30);
            $table->string('id_role', 5)->nullable();
            $table->string('name', 30);
            $table->string('email',40)->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 200);
            $table->string('status_aktif', 20);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
