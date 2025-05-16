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
         Schema::table('orders', function (Blueprint $table) {
        $table->enum('status', ['en attente', 'en cours', 'livrée', 'retour', 'problème'])->default('en attente');
        $table->text('delivery_comment')->nullable();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
};
