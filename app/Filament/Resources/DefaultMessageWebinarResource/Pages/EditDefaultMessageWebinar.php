<?php

namespace App\Filament\Resources\DefaultMessageWebinarResource\Pages;

use App\Filament\Resources\DefaultMessageWebinarResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDefaultMessageWebinar extends EditRecord
{
    protected static string $resource = DefaultMessageWebinarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
