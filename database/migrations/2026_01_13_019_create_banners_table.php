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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->json('title')->nullable(); // {"ar": "...", "en": "..."}
            $table->json('subtitle')->nullable(); // {"ar": "...", "en": "..."}
            $table->string('image');
            $table->string('mobile_image')->nullable();
            $table->string('link_type')->nullable(); // product, category, brand, external, none
            $table->unsignedBigInteger('link_id')->nullable(); // product_id, category_id, brand_id
            $table->string('external_url')->nullable();
            $table->string('position')->default('home_slider'); // home_slider, home_banner, category_banner
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            
            $table->index(['position', 'is_active']);
            $table->index(['start_date', 'end_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
