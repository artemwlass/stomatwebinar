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
            $table->foreignId('series_webinar_id')->constrained('webinars');
            $table->foreignId('webinar_id')->constrained('webinars');
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
