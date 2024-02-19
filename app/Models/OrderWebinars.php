<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderWebinars extends Model
{
    use HasFactory;
    protected $guarded = false;

    public function webinar()
    {
        return $this->belongsTo(Webinar::class);
    }

}
