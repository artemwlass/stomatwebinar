<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Webinar extends Model
{
    use HasFactory;
    protected $guarded = false;
    protected $casts = [
        'seo' => 'array',
        'content' => 'array',
    ];

    public function group()
    {
        return $this->hasOne(Group::class);
    }

    // Вебинары в серии
    public function seriesWebinars()
    {
        return $this->belongsToMany(Webinar::class, 'series_webinars', 'series_webinar_id', 'webinar_id');
    }

    // Серии, к которым принадлежит вебинар
    public function belongsToSeries()
    {
        return $this->belongsToMany(Webinar::class, 'series_webinars', 'webinar_id', 'series_webinar_id');
    }


}
