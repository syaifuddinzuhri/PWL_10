<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMahasiswaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->string('nim', 20)->primary();
            $table->string('nama', 75)->nullable();
            $table->string('email', 100)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->unsignedBigInteger('kelas_id')->nullable();
            $table->string('jurusan', 30)->nullable();
            $table->string('no_handphone', 14)->nullable();
            $table->string('photo')->nullable();
            $table->timestamps();

            $table->foreign('kelas_id')->references('id')->on('kelas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mahasiswa');
    }
}