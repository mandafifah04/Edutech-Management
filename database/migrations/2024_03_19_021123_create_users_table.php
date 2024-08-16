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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username', 128);
            $table->string('email', 128)->unique();
            $table->string('password');
            $table->foreignId('level_trainers_id')->nullable()->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->enum('roles', ['hrd', 'kurikulum', 'keuangan', 'trainer']);
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
