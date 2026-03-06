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
        Schema::create('payment_attempts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->unsignedBigInteger('order_id')->nullable()->index();
            $table->string('payment_token')->unique();
            $table->string('liqpay_order_id')->unique();
            $table->decimal('amount', 10, 2)->nullable();
            $table->string('currency', 3)->default('UAH');
            $table->string('status', 20)->default('pending'); // pending|failed|paid
            $table->string('description')->nullable();
            $table->string('user_email')->nullable();
            $table->string('user_phone')->nullable();
            $table->string('user_name')->nullable();
            $table->string('user_surname')->nullable();
            $table->json('attribution_data')->nullable();
            $table->json('cart_data')->nullable();
            $table->json('callback_payload')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('failed_at')->nullable();
            $table->string('failed_reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_attempts');
    }
};
