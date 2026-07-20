<?php

namespace App\Filament\Resources\DefaultMessagePurchaseRegistrationResource\Pages;

use App\Filament\Resources\DefaultMessagePurchaseRegistrationResource;
use App\Models\DefaultMessagePurchaseRegistration;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDefaultMessagePurchaseRegistrations extends ListRecords
{
    protected static string $resource = DefaultMessagePurchaseRegistrationResource::class;
    public static ?string $title = 'Сообщение';

    protected function getHeaderActions(): array
    {
        if (DefaultMessagePurchaseRegistration::count() > 0) {
            return [];
        }

        return [
            Actions\CreateAction::make(),
        ];
    }
}
