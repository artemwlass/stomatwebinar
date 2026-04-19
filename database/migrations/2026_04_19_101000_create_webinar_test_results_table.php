<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('webinar_test_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('webinar_id')->index();
            $table->unsignedInteger('score_percent')->default(0);
            $table->boolean('is_passed')->default(false);
            $table->unsignedInteger('attempts_count')->default(0);
            $table->json('answers')->nullable();
            $table->string('certificate_number', 6)->nullable()->unique();
            $table->timestamp('passed_at')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'webinar_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('webinar_test_results');
    }
};
