<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jadwal_kelas', function (Blueprint $table) {
            $table->id();
            $table->string('kelas_id')->references('id')->on('kelas');
            $table->string('hari_jadwal_kelas');
            $table->date('tanggal_jadwal_kelas');
            $table->time('jam_mulai_jadwal_kelas');
            $table->time('jam_akhir_jadwal_kelas');
            $table->enum('status', ['N', 'Y']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_kelas');
    }
};
