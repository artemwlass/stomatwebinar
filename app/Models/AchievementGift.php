<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AchievementGift extends Model
{
    protected $guarded = false;
    protected $casts = ['is_active' => 'boolean', 'discount_value' => 'decimal:2'];

    public function level()
    {
        return $this->belongsTo(AchievementLevel::class, 'achievement_level_id');
    }

    public function claims()
    {
        return $this->hasMany(AchievementClaim::class);
    }

    public function calculateDiscount(float $amount): float
    {
        if ($this->gift_type !== 'webinar_discount' || $amount <= 0) {
            return 0;
        }

        $discount = $this->discount_type === 'percent'
            ? $amount * ((float) $this->discount_value / 100)
            : (float) $this->discount_value;

        return round(min($amount, max(0, $discount)), 2);
    }
}
