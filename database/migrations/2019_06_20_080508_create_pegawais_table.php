<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePegawaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pegawais', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nip')->unique();
            $table->string('nama');
            $table->string('alamat');
            $table->string('telepon')->unique();
            $table->string('jenis_kelamin');
            $table->integer('id_jabatan')->unsigned()->nullable();
            $table->foreign('id_jabatan')
                  ->references('id')->on('jabatans')
                  ->onUpdate('cascade')
                  ->onDelete('set null');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
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
        Schema::dropIfExists('pegawais');
    }
}
