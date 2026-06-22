<?php

namespace App\Support;

use App\Models\AchievementGift;
use App\Models\AchievementClaim;
use App\Models\PromoCode;

class PromoCodeCalculator
{
    public static function normalizeCode(?string $code): string
    {
        return mb_strtoupper(trim((string) $code));
    }

    public static function findValid(?string $code): ?PromoCode
    {
        $normalizedCode = self::normalizeCode($code);

        if ($normalizedCode === '') {
            return null;
        }

        $promoCode = PromoCode::query()
            ->where('code', $normalizedCode)
            ->first();

        return $promoCode?->isValid() ? $promoCode : null;
    }

    public static function findValidDiscount(?string $code): PromoCode|AchievementGift|null
    {
        if ($promoCode = self::findValid($code)) {
            return $promoCode;
        }

        if (! auth()->check()) {
            return null;
        }

        $normalizedCode = self::normalizeCode($code);

        return AchievementClaim::query()
            ->with('gift')
            ->where('user_id', auth()->id())
            ->where('code_snapshot', $normalizedCode)
            ->where(function ($query) {
                $query->whereNull('expires_at')->orWhere('expires_at', '>', now());
            })
            ->whereHas('gift', function ($query) {
                $query->where('gift_type', 'webinar_discount')->where('is_active', true);
            })
            ->first()?->gift;
    }

    public static function cartSubtotal(): float
    {
        $subtotalRaw = (string) \Gloudemans\Shoppingcart\Facades\Cart::subtotal();
        $subtotalSanitized = preg_replace('/[^\d.,]/', '', $subtotalRaw);
        $lastCommaPosition = strrpos($subtotalSanitized, ',');
        $lastDotPosition = strrpos($subtotalSanitized, '.');

        if ($lastCommaPosition !== false && $lastDotPosition !== false) {
            if ($lastCommaPosition > $lastDotPosition) {
                $subtotalSanitized = str_replace('.', '', $subtotalSanitized);
                $subtotalSanitized = str_replace(',', '.', $subtotalSanitized);
            } else {
                $subtotalSanitized = str_replace(',', '', $subtotalSanitized);
            }
        } elseif ($lastCommaPosition !== false) {
            $subtotalSanitized = str_replace(',', '.', $subtotalSanitized);
        }

        return round((float) $subtotalSanitized, 2);
    }

    public static function discountData(?string $code, float $amount): array
    {
        $promoCode = self::findValidDiscount($code);

        if (!$promoCode) {
            return [
                'promo_code' => null,
                'discount_amount' => 0,
                'total_amount' => $amount,
            ];
        }

        $discount = $promoCode->calculateDiscount($amount);

        return [
            'promo_code' => self::normalizeCode($code),
            'discount_amount' => $discount,
            'total_amount' => round(max(0, $amount - $discount), 2),
        ];
    }
}
