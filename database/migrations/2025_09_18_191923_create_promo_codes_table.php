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
     Schema::create('promo_codes', function (Blueprint $table) {
    $table->id();
    $table->string('code')->unique(); // ex: PROMO10
    $table->enum('type', ['fixed', 'percent']); // réduction fixe ou en %
    $table->decimal('value', 8, 2); // ex: 10.00 (MAD ou %)
    $table->date('expires_at')->nullable(); // date d’expiration
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promo_codes');
    }
};
