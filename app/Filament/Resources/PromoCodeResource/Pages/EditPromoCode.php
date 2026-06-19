<?php

namespace App\Filament\Resources\PromoCodeResource\Pages;

use App\Filament\Resources\PromoCodeResource;
use Filament\Resources\Pages\EditRecord;

class EditPromoCode extends EditRecord
{
    protected static string $resource = PromoCodeResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (!empty($data['validity_days'])) {
            $data['expires_at'] = now()->addDays((int) $data['validity_days']);
        } else {
            $data['expires_at'] = null;
        }

        return $data;
    }
}
