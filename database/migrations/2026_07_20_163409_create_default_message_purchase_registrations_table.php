<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('default_message_purchase_registrations', function (Blueprint $table) {
            $table->id();
            $table->text('message');
            $table->timestamps();
        });

        DB::table('default_message_purchase_registrations')->insert([
            'message' => 'Шановний(а) [NAME],<br><br>Дякуємо Вам за реєстрацію на сайті.<br><br>Ваш логін: [EMAIL]<br>Пароль: [PASSWORD]<br><br><br>З повагою,<br>Команда stomatwebinar.com<br>stomatwebinar30@gmail.com<br>+380 99 092 64 45<br>',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('default_message_purchase_registrations');
    }
};
