<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('account_pages', function (Blueprint $table) {
            $table->longText('header_top_content')->nullable()->after('dashboard_stats');
        });
    }

    public function down(): void
    {
        Schema::table('account_pages', function (Blueprint $table) {
            $table->dropColumn('header_top_content');
        });
    }
};
