<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDisposisisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disposisis', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nomor_agenda')->unique()->nullable();
            // $table->date('tgl_terima');//sm
            $table->date('tgl_selesai')->nullable();
            // $table->string('tkt_keamanan');//sm
            // $table->string('no_surat');//sm
            // $table->string('dari');//sm
            $table->string('isi')->nullable();
            $table->string('catatan');
            // $table->string('lampiran')->nullable(); //sm
            $table->string('disposisi');
            $table->string('diteruskan');
            $table->string('paraf');
            $table->string('softfile');
            $table->string('id_penerima');
            $table->string('id_pembuat');
            $table->integer('id_surmas')->unsigned();
            $table->foreign('id_surmas')
                  ->references('id')->on('surat_masuks')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->string('status');
            $table->string('read');
            $table->string('hardcopy');
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
        Schema::dropIfExists('disposisis');
    }
}
