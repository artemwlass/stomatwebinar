<?php

namespace App\Http\Controllers;

use App\Models\GroupUser;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ExchangeDateController extends Controller
{
    public function updateClosedWebinarDate($record, $days): void
    {
        $groupUserRecord = GroupUser::where('group_id', $record['pivot_group_id'])
            ->where('user_id', $record['pivot_user_id'])
            ->first();

        if ($groupUserRecord && $groupUserRecord->closed_webinar_date) {
            // Увеличиваем дату на указанное количество дней
            $newDate = Carbon::parse($groupUserRecord->closed_webinar_date)->addDays($days);

            // Обновляем запись
            $groupUserRecord->closed_webinar_date = $newDate;
            $groupUserRecord->save();
        }
    }

    public function updateClosedWebinarDateAllGroup($record, $days): void
    {
        $groupUsersRecord = GroupUser::where('group_id', $record)->get();

        foreach ($groupUsersRecord as $value) {
            if ($value && $value->closed_webinar_date) {
                // Увеличиваем дату на указанное количество дней
                $newDate = Carbon::parse($value->closed_webinar_date)->addDays($days);

                // Обновляем запись
                $value->closed_webinar_date = $newDate;
                $value->save();
            }
        }
    }
}
