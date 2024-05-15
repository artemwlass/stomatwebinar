<?php

namespace App\Filament\Resources\MessagePreorderWebinarFreeResource\Pages;

use App\Filament\Resources\MessagePreorderWebinarFreeResource;
use App\Models\MessagePreorderWebinarFree;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMessagePreorderWebinarFrees extends ListRecords
{
    protected static string $resource = MessagePreorderWebinarFreeResource::class;
    public static ?string $title = 'Сообщение';

    protected function getHeaderActions(): array
    {
        if (MessagePreorderWebinarFree::count() > 0) {
            return [];
        } else {
            return [
                Actions\CreateAction::make(),
            ];
        }

    }
}
