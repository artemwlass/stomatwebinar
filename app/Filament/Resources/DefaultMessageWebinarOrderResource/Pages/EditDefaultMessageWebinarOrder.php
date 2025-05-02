<?php

namespace App\Filament\Resources\DefaultMessageWebinarOrderResource\Pages;

use App\Filament\Resources\DefaultMessageWebinarOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDefaultMessageWebinarOrder extends EditRecord
{
    protected static string $resource = DefaultMessageWebinarOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
