<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromoCode extends Model
{
    protected $guarded = false;

    protected $casts = [
        'discount_value' => 'decimal:2',
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function isValid(): bool
    {
        return $this->is_active && ($this->expires_at === null || $this->expires_at->isFuture());
    }

    public function calculateDiscount(float $amount): float
    {
        if (!$this->isValid() || $amount <= 0) {
            return 0;
        }

        $discount = $this->discount_type === 'percent'
            ? $amount * ((float) $this->discount_value / 100)
            : (float) $this->discount_value;

        return round(min($amount, max(0, $discount)), 2);
    }
}
