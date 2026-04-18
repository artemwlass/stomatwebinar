<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('country')->nullable()->after('city');
            $table->date('birthday')->nullable()->after('country');
            $table->string('work_place')->nullable()->after('phone');
            $table->string('position')->nullable()->after('work_place');
            $table->string('specialty')->nullable()->after('position');
            $table->timestamp('account_profile_confirmed_at')->nullable()->after('specialty');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'country',
                'birthday',
                'work_place',
                'position',
                'specialty',
                'account_profile_confirmed_at',
            ]);
        });
    }
};
