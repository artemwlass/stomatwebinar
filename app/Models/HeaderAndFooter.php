<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeaderAndFooter extends Model
{
    use HasFactory;
    protected $guarded = false;

    protected $casts = [
        'menu' => 'array',
        'footer_menu1' => 'array',
        'footer_menu2' => 'array',
    ];
}
