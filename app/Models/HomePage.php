<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomePage extends Model
{
    use HasFactory;
    protected $guarded = false;

    protected $casts = [
        'seo' => 'array',
        'block_highlight' => 'array',
        'block_hero' => 'array',
        'block_about' => 'array',
        'schedule_webinar' => 'array',
        'schedule_lesson' => 'array',
        'second_banner' => 'array',
    ];
}
