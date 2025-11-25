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
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->index();
            $table->string('nip')->unique()->index();
            $table->string('unit_kerja')->index();
            $table->string('foto')->nullable();
            $table->enum('status_hadir', ['Hadir', 'Tidak hadir'])->default('Tidak hadir')->index();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->boolean('sudah_menang')->default(false)->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participants');
    }
};
