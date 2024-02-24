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
        Schema::create('series_webinars', function (Blueprint $table) {
            $table->id();
            $table->json('seo');
            $table->string('title');
            $table->string('slug');
            $table->string('image');
            $table->boolean('is_active')->default(true);
            $table->json('content');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('series_webinars');
    }
};
