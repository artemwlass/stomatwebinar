<?php

namespace App\Filament\Resources\DogovorOfertyResource\Pages;

use App\Filament\Resources\DogovorOfertyResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDogovorOferty extends EditRecord
{
    protected static string $resource = DogovorOfertyResource::class;
    public static ?string $title = 'Редактирование';

    protected function getHeaderActions(): array
    {
        return [
//            Actions\DeleteAction::make(),
        ];
    }
}
