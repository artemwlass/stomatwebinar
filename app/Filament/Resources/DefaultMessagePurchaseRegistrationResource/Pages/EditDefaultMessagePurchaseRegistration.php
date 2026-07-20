<?php

namespace App\Filament\Resources\DefaultMessagePurchaseRegistrationResource\Pages;

use App\Filament\Resources\DefaultMessagePurchaseRegistrationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDefaultMessagePurchaseRegistration extends EditRecord
{
    protected static string $resource = DefaultMessagePurchaseRegistrationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
