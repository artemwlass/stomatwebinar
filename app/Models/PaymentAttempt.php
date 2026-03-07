<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentAttempt extends Model
{
    use HasFactory;

    protected $guarded = false;

    protected $casts = [
        'attribution_data' => 'array',
        'cart_data' => 'array',
        'callback_payload' => 'array',
        'paid_at' => 'datetime',
        'failed_at' => 'datetime',
        'unpaid_sheet_synced_at' => 'datetime',
        'unpaid_telegram_sent_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
