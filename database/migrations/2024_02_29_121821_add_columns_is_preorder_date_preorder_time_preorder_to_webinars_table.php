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
        Schema::table('webinars', function (Blueprint $table) {
            $table->boolean('is_preorder')->default(false);
            $table->date('date_preorder')->nullable();
            $table->time('time_preorder')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('webinars', function (Blueprint $table) {
            $table->dropColumn('is_preorder');
            $table->dropColumn('date_preorder');
            $table->dropColumn('time_preorder');
        });
    }
};
