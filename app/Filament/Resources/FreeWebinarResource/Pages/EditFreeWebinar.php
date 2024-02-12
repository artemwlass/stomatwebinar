<?php

namespace App\Filament\Resources\FreeWebinarResource\Pages;

use App\Filament\Resources\FreeWebinarResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;

class EditFreeWebinar extends EditRecord
{
    protected static string $resource = FreeWebinarResource::class;

    public function getTitle(): string | Htmlable
    {
        return __($this->record->name . ' - Редактирование');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
