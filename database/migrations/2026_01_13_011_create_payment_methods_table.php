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
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // cash, card, wallet, etc.
            $table->json('name'); // {"ar": "...", "en": "..."}
            $table->json('description')->nullable(); // {"ar": "...", "en": "..."}
            $table->string('icon')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('requires_payment_proof')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
