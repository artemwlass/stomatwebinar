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
        Schema::create('index_pages', function (Blueprint $table) {
            $table->id();
            $table->json('seo')->nullable();
            $table->json('hero')->nullable();
            $table->json('highlight')->nullable();
            $table->json('services')->nullable();
            $table->json('about')->nullable();
            $table->json('swiper')->nullable();
            $table->json('schedule')->nullable();
            $table->json('cta_banner')->nullable();
            $table->json('service_free')->nullable();
            $table->json('faq')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('index_pages');
    }
};
