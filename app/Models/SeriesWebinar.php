<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeriesWebinar extends Model
{
    use HasFactory;
    protected $guarded = false;

    // Вебинар-серия
    public function series()
    {
        return $this->belongsTo(Webinar::class, 'series_webinar_id');
    }

    // Вебинар в серии
    public function webinar()
    {
        return $this->belongsTo(Webinar::class, 'webinar_id');
    }
}
