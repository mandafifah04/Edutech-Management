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
        Schema::create('sallaryreports', function (Blueprint $table) {
            $table->id();
            $table->string('users_id');
            $table->foreignId('kelas_id')->references('id')->on('kelas');
            $table->integer('total_gaji');
            $table->enum('status', ['unverified', 'verified']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sallaryreports');
    }
};
