<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AchievementClaim extends Model
{
    protected $guarded = false;
    protected $casts = ['expires_at' => 'datetime', 'claimed_at' => 'datetime'];

    public function user() { return $this->belongsTo(User::class); }
    public function level() { return $this->belongsTo(AchievementLevel::class, 'achievement_level_id'); }
    public function gift() { return $this->belongsTo(AchievementGift::class, 'achievement_gift_id'); }
}
