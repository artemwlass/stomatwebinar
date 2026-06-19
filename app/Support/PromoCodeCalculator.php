<?php

namespace App\Support;

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
        $promoCode = self::findValid($code);

        if (!$promoCode) {
            return [
                'promo_code' => null,
                'discount_amount' => 0,
                'total_amount' => $amount,
            ];
        }

        $discount = $promoCode->calculateDiscount($amount);

        return [
            'promo_code' => $promoCode->code,
            'discount_amount' => $discount,
            'total_amount' => round(max(0, $amount - $discount), 2),
        ];
    }
}
