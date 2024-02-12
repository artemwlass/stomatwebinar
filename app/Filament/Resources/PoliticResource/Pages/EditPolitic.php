<?php

namespace App\Filament\Resources\PoliticResource\Pages;

use App\Filament\Resources\PoliticResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPolitic extends EditRecord
{
    protected static string $resource = PoliticResource::class;
    public static ?string $title = 'Редактирование';

    protected function getHeaderActions(): array
    {
        return [
//            Actions\DeleteAction::make(),
        ];
    }
}
