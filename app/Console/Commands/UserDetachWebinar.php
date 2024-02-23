<?php

namespace App\Console\Commands;

use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class UserDetachWebinar extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:detach-webinar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Открепление пользователей из группы, если вышел срок';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $today = Carbon::today();

            // Получение всех пользователей, которые привязаны к группам с потенциально истекшей датой
            $users = User::whereHas('groups', function ($query) use ($today) {
                $query->where('closed_webinar_date', '<=', $today);
            })->get();

            foreach ($users as $user) {
                // Для каждого пользователя получаем группы
                $groups = $user->groups()->get();

                foreach ($groups as $group) {
                    // Проверяем, что дата закрытия меньше текущей дате
                    if (Carbon::parse($group->pivot->closed_webinar_date)->endOfDay() < $today) {
                        // Отвязываем пользователя от группы
                        $user->groups()->detach($group->id);
                    }
                }
            }
        } catch (Exception $e) {
            // Логирование ошибки
            Log::error('Error detaching users from groups: ' . $e->getMessage());
        }
    }
}
