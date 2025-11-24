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
        Schema::create('rewards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reward_category_id')->constrained('reward_categories')->cascadeOnDelete();
            $table->string('nama_hadiah')->index();
            $table->string('gambar')->nullable();
            $table->integer('stok')->default(0);
            $table->enum('status_hadiah', ['Aktif', 'Tidak aktif'])->default('Aktif')->index();
            $table->enum('level_hadiah', ['Utama', 'Hiburan'])->default('Hiburan')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rewards');
    }
};
