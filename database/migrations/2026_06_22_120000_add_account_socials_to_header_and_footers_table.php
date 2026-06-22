<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('header_and_footers', function (Blueprint $table) {
            $table->string('account_footer_facebook')->nullable()->after('footer_youtube');
            $table->string('account_footer_telegram')->nullable()->after('account_footer_facebook');
            $table->string('account_footer_instagram')->nullable()->after('account_footer_telegram');
            $table->string('account_footer_youtube')->nullable()->after('account_footer_instagram');
        });
    }

    public function down(): void
    {
        Schema::table('header_and_footers', function (Blueprint $table) {
            $table->dropColumn([
                'account_footer_facebook',
                'account_footer_telegram',
                'account_footer_instagram',
                'account_footer_youtube',
            ]);
        });
    }
};
