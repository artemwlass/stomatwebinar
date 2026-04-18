<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('webinars', function (Blueprint $table) {
            $table->json('lecturers')->nullable()->after('bpr_points');
            $table->date('date_testing_start')->nullable()->after('time_preorder');
            $table->time('time_testing_start')->nullable()->after('date_testing_start');
            $table->date('date_testing_end')->nullable()->after('time_testing_start');
            $table->time('time_testing_end')->nullable()->after('date_testing_end');
        });
    }

    public function down(): void
    {
        Schema::table('webinars', function (Blueprint $table) {
            $table->dropColumn([
                'lecturers',
                'date_testing_start',
                'time_testing_start',
                'date_testing_end',
                'time_testing_end',
            ]);
        });
    }
};
