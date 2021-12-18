<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuratKeluarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surat_keluars', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nomor')->unique()->nullable();
            $table->string('kepada');
            $table->string('dari');
            $table->string('tembusan')->nullable();
            $table->date('tanggal');
            $table->string('sifat');
            $table->string('lampiran')->nullable();
            $table->string('hal');
            $table->string('softfile');
            $table->string('koreksi')->nullable();
            $table->string('id_penerima');
            $table->string('id_pembuat');
            $table->string('status');
            $table->string('read');
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
        Schema::dropIfExists('surat_keluars');
    }
}
