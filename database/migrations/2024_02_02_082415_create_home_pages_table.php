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
        Schema::create('home_pages', function (Blueprint $table) {
            $table->id();
            $table->json('seo');
            $table->json('block_hero')->nullable();
            $table->json('block_highlight')->nullable();
            $table->json('block_about')->nullable();
            $table->json('schedule_webinar')->nullable();
            $table->json('schedule_lesson')->nullable();
            $table->json('second_banner')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_pages');
    }
};
