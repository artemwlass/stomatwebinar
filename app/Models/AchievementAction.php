<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AchievementAction extends Model
{
    protected $guarded = false;
    protected $casts = ['is_active' => 'boolean'];
}
