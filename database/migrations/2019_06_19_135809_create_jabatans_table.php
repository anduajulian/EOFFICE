<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJabatansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jabatans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('jabatan');
        });

        DB::table('jabatans')->insert(
            [ 
                ['jabatan' => 'KEPALA DINAS Komunikasi dan Informatika'],
                ['jabatan' => 'SEKRETARIS DINAS'],
                ['jabatan' => 'KEPALA SUB BAGIAN KEUANGAN DAN ASET'],
                ['jabatan' => 'KEPALA SUB BAGIAN KEPEGAWAIAN DAN UMUM'],
                ['jabatan' => 'KEPALA SUB BAGIAN PERENCANAAN DAN PELAPORAN'],
                ['jabatan' => 'KEPALA BIDANG E-GOVERNMENT'],
                ['jabatan' => 'KEPALA SEKSI TATA KELOLA'],
                ['jabatan' => 'KEPALA SEKSI PENGELOLAAN INFRASTRUKTUR'],
                ['jabatan' => 'KEPALA SEKSI LAYANAN INFRASTRUKTUR '],
                ['jabatan' => 'KEPALA BIDANG APLIKASI INFORMATIKA'],
                ['jabatan' => 'KEPALA SEKSI REKAYASA APLIKASI'],
                ['jabatan' => 'KEPALA SEKSI INTEGRASI DAN INTEROPERABILITAS'],
                ['jabatan' => 'KEPALA SEKSI PENGELOLAAN APLIKASIS'],
                ['jabatan' => 'KEPALA BIDANG INFORMASI KOMUNIKASI PUBLIK'],
                ['jabatan' => 'KEPALA SEKSI PENGOLAHAN DAN PENYEDIAAN INFORMASI'],
                ['jabatan' => 'KEPALA SEKSI KOMUNIKASI PUBLIK'],
                ['jabatan' => 'KEPALA SEKSI KEMITRAAN KOMUNIKASI'],
                ['jabatan' => 'KEPALA BIDANG PERSANDIAN DAN KEAMANAN INFORMASI'],
                ['jabatan' => 'KEPALA SEKSI PERSANDIAN'],
                ['jabatan' => 'KEPALA SEKSI KEAMANAN INFORMASI'],
                ['jabatan' => 'KEPALA SEKSI LAYANAN KEAMANAN INFORMASI'],
                ['jabatan' => 'KEPALA BIDANG STATISTIK'],
                ['jabatan' => 'KEPALA SEKSI KOMPILASI DATA'],
                ['jabatan' => 'KEPALA SEKSI PENGOLAHAN DATA'],
                ['jabatan' => 'KEPALA SEKSI PENYAJIAN DATA']
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jabatans');
    }
}
