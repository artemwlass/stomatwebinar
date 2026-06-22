<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('account_pages', function (Blueprint $table): void {
            $table->json('header_links')->nullable()->after('header_top_content');
        });

        DB::table('account_pages')->whereNull('header_links')->update([
            'header_links' => json_encode([
                ['label' => 'Найближчий вебінар', 'url' => '/'],
                ['label' => 'Купити все для ендо', 'url' => '/'],
                ['label' => 'Безкоштовні вебінари', 'url' => '/'],
                ['label' => 'Контакти', 'url' => '/'],
            ], JSON_UNESCAPED_UNICODE),
        ]);
    }

    public function down(): void
    {
        Schema::table('account_pages', function (Blueprint $table): void {
            $table->dropColumn('header_links');
        });
    }
};
