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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('participant_id')->nullable()->constrained('participants')->cascadeOnDelete();
            $table->string('kode_kupon')->unique()->index();
            $table->enum('status_kupon', ['Aktif', 'Kadaluarsa'])
                ->default('Aktif')
                ->index();
            $table->foreignId('store_id')->nullable()->constrained('stores')->nullOnDelete();
            $table->timestamp('redeemed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
