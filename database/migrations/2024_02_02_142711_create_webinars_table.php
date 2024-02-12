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
        Schema::create('webinars', function (Blueprint $table) {
            $table->id();
            $table->json('seo');
            $table->string('title');
            $table->string('slug');
            $table->string('image');
            $table->boolean('is_free')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('order');
            $table->json('content');
            $table->string('title_view_page')->nullable();
            $table->text('description_view_page')->nullable();
            $table->string('video_view_page')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('webinars');
    }
};
