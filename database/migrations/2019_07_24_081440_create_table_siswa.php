<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSiswa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    //method up digunakan untuk menjalankan migrasi (membuat)
    public function up()
    {
        Schema::create('siswa', function (Blueprint $table) {
            $table->Increments('id');
            $table->string('nisn', 4)-> unique();
            $table->string('nama_siswa', 30);
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['L','P']);
            $table->integer('id_kelas')->unsigned(); //menghubung ke tabel kelas
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    //method down digunakan untk rollback (membatalkan)
    public function down()
    {
        Schema::dropIfExists('siswa');
    }
}
