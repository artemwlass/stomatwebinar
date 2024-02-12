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
        Schema::create('header_and_footers', function (Blueprint $table) {
            $table->id();
            $table->json('menu');
            $table->string('footer_phone');
            $table->string('footer_email');
            $table->string('footer_facebook');
            $table->string('footer_telegram');
            $table->string('footer_instagram');
            $table->string('footer_youtube');
            $table->json('footer_menu1');
            $table->json('footer_menu2');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('header_and_footers');
    }
};
