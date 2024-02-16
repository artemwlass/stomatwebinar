<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    protected $guarded = false;

    public function users()
    {
        return $this->belongsToMany(User::class, 'group_users')->withPivot('closed_webinar_date');
    }

    public function webinar()
    {
        return $this->belongsTo(Webinar::class, 'webinar_id');
    }
}
