<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('achievement_actions', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('title');
            $table->integer('points')->default(0);
            $table->string('icon')->nullable();
            $table->unsignedInteger('sort')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('achievement_levels', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedInteger('points_required');
            $table->string('image')->nullable();
            $table->unsignedInteger('sort')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('achievement_gifts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('achievement_level_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->enum('gift_type', ['webinar_discount', 'partner']);
            $table->enum('discount_type', ['fixed', 'percent'])->nullable();
            $table->decimal('discount_value', 10, 2)->nullable();
            $table->string('code')->unique();
            $table->string('partner_url')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->unsignedSmallInteger('validity_days')->nullable();
            $table->unsignedInteger('sort')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('achievement_point_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('achievement_action_id')->nullable()->constrained()->nullOnDelete();
            $table->integer('points');
            $table->string('description');
            $table->nullableMorphs('subject');
            $table->string('unique_key')->nullable()->unique();
            $table->json('metadata')->nullable();
            $table->timestamps();
        });

        Schema::create('achievement_claims', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('achievement_level_id')->constrained()->cascadeOnDelete();
            $table->foreignId('achievement_gift_id')->constrained()->cascadeOnDelete();
            $table->string('title_snapshot');
            $table->string('code_snapshot');
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('claimed_at');
            $table->timestamps();
            $table->unique(['user_id', 'achievement_level_id']);
        });

        $now = now();
        DB::table('achievement_actions')->insert([
            ['code' => 'case_read', 'title' => 'Прочитати кейс', 'points' => 1, 'icon' => 'achievement-point-book.svg', 'sort' => 10, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'equipment_view', 'title' => 'Огляд продукції', 'points' => 1, 'icon' => 'achievement-point-video.svg', 'sort' => 20, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'article_read', 'title' => 'Прочитали статтю', 'points' => 1, 'icon' => 'achievement-point-article-1.svg', 'sort' => 30, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'case_published', 'title' => 'Запропонували свій кейс і його опублікували', 'points' => 15, 'icon' => 'achievement-point-publish.svg', 'sort' => 40, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'webinar_purchase', 'title' => 'Купівля вебінару', 'points' => 20, 'icon' => 'achievement-point-coins.svg', 'sort' => 50, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'equipment_published', 'title' => 'Розгорнутий відгук + відео', 'points' => 50, 'icon' => 'achievement-point-video.svg', 'sort' => 60, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'package_purchase', 'title' => 'Купівля пакету вебінарів', 'points' => 150, 'icon' => 'achievement-point-coins.svg', 'sort' => 70, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
        ]);

        DB::table('achievement_levels')->insert([
            ['title' => 'Рівень 1', 'points_required' => 100, 'sort' => 10, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['title' => 'Рівень 2', 'points_required' => 250, 'sort' => 20, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['title' => 'Рівень 3', 'points_required' => 450, 'sort' => 30, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['title' => 'Рівень 4', 'points_required' => 700, 'sort' => 40, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['title' => 'Рівень 5', 'points_required' => 950, 'sort' => 50, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('achievement_claims');
        Schema::dropIfExists('achievement_point_transactions');
        Schema::dropIfExists('achievement_gifts');
        Schema::dropIfExists('achievement_levels');
        Schema::dropIfExists('achievement_actions');
    }
};
