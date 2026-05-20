<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountPage extends Model
{
    use HasFactory;

    protected $guarded = false;

    protected $casts = [
        'dashboard_stats' => 'array',
        'header_top_content' => 'string',
    ];
}
