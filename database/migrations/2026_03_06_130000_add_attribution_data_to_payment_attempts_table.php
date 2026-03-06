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

        if (!Schema::hasColumn('payment_attempts', 'attribution_data')) {
            Schema::table('payment_attempts', function (Blueprint $table) {
                $table->json('attribution_data')->nullable()->after('user_surname');
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

        if (Schema::hasColumn('payment_attempts', 'attribution_data')) {
            Schema::table('payment_attempts', function (Blueprint $table) {
                $table->dropColumn('attribution_data');
            });
        }
    }
};

