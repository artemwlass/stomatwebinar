<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clinical_cases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('author_name');
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('gender')->nullable();
            $table->unsignedSmallInteger('age')->nullable();
            $table->text('complaints')->nullable();
            $table->text('medical_history')->nullable();
            $table->text('examination')->nullable();
            $table->longText('content');
            $table->json('media')->nullable();
            $table->timestamp('published_at')->nullable()->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clinical_cases');
    }
};
