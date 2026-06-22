<?php

namespace App\Support;

use App\Models\AchievementAction;
use App\Models\AchievementPointTransaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class AchievementPoints
{
    public static function balance(int|User $user): int
    {
        $userId = $user instanceof User ? $user->id : $user;

        return (int) AchievementPointTransaction::where('user_id', $userId)->sum('points');
    }

    public static function awardOnce(int|User $user, string $actionCode, Model $subject, ?string $description = null): ?AchievementPointTransaction
    {
        $userId = $user instanceof User ? $user->id : $user;
        $key = hash('sha256', implode(':', [$userId, $actionCode, $subject->getMorphClass(), $subject->getKey()]));

        return self::awardWithKey($userId, $actionCode, $key, $description, $subject);
    }

    public static function awardWithKey(int|User $user, string $actionCode, string $key, ?string $description = null, ?Model $subject = null): ?AchievementPointTransaction
    {
        $userId = $user instanceof User ? $user->id : $user;
        $action = AchievementAction::where('code', $actionCode)->where('is_active', true)->first();

        if (! $action || $action->points === 0) {
            return null;
        }

        return AchievementPointTransaction::firstOrCreate(
            ['unique_key' => $key],
            [
                'user_id' => $userId,
                'achievement_action_id' => $action->id,
                'points' => $action->points,
                'description' => $description ?: $action->title,
                'subject_type' => $subject?->getMorphClass(),
                'subject_id' => $subject?->getKey(),
            ]
        );
    }

    public static function adjust(int|User $user, int $points, string $description): AchievementPointTransaction
    {
        $userId = $user instanceof User ? $user->id : $user;

        return AchievementPointTransaction::create([
            'user_id' => $userId,
            'points' => $points,
            'description' => $description,
        ]);
    }
}
