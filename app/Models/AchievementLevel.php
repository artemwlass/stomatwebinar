<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AchievementLevel extends Model
{
    protected $guarded = false;
    protected $casts = ['is_active' => 'boolean'];

    public function gifts()
    {
        return $this->hasMany(AchievementGift::class)->orderBy('sort');
    }

    public function claims()
    {
        return $this->hasMany(AchievementClaim::class);
    }
}
