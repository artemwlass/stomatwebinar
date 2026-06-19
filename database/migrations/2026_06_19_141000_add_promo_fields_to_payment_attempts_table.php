<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payment_attempts', function (Blueprint $table) {
            $table->string('promo_code')->nullable()->after('currency');
            $table->decimal('discount_amount', 10, 2)->default(0)->after('promo_code');
            $table->decimal('original_amount', 10, 2)->nullable()->after('discount_amount');
        });
    }

    public function down(): void
    {
        Schema::table('payment_attempts', function (Blueprint $table) {
            $table->dropColumn(['promo_code', 'discount_amount', 'original_amount']);
        });
    }
};
