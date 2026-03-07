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
        if (!Schema::hasTable('payment_attempts')) {
            return;
        }

        if (!Schema::hasColumn('payment_attempts', 'unpaid_telegram_sent_at')) {
            Schema::table('payment_attempts', function (Blueprint $table) {
                $table->timestamp('unpaid_telegram_sent_at')->nullable()->after('unpaid_sheet_synced_at');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('payment_attempts')) {
            return;
        }

        if (Schema::hasColumn('payment_attempts', 'unpaid_telegram_sent_at')) {
            Schema::table('payment_attempts', function (Blueprint $table) {
                $table->dropColumn('unpaid_telegram_sent_at');
            });
        }
    }
};

