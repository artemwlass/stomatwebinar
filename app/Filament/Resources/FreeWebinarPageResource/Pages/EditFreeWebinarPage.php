<?php

namespace App\Filament\Resources\FreeWebinarPageResource\Pages;

use App\Filament\Resources\FreeWebinarPageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFreeWebinarPage extends EditRecord
{
    protected static string $resource = FreeWebinarPageResource::class;
    public static ?string $title = 'Страница бесплатных вебинаров - Редактирование';

    protected function getHeaderActions(): array
    {
        return [
//            Actions\DeleteAction::make(),
        ];
    }
}
