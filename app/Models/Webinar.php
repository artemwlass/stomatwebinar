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

}
