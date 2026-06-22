<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AchievementPointTransaction extends Model
{
    protected $guarded = false;
    protected $casts = ['metadata' => 'array'];

    public function user() { return $this->belongsTo(User::class); }
    public function action() { return $this->belongsTo(AchievementAction::class, 'achievement_action_id'); }
    public function subject() { return $this->morphTo(); }
}
