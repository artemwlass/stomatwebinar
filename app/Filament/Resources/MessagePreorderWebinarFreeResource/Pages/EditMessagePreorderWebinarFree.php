<?php

namespace App\Filament\Resources\MessagePreorderWebinarFreeResource\Pages;

use App\Filament\Resources\MessagePreorderWebinarFreeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMessagePreorderWebinarFree extends EditRecord
{
    protected static string $resource = MessagePreorderWebinarFreeResource::class;
    public static ?string $title = 'Редактировать';

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
