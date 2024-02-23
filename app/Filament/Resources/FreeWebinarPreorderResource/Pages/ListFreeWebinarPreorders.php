<?php

namespace App\Filament\Resources\FreeWebinarPreorderResource\Pages;

use App\Filament\Resources\FreeWebinarPreorderResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFreeWebinarPreorders extends ListRecords
{
    protected static string $resource = FreeWebinarPreorderResource::class;

    public static ?string $title = 'Страницы предзаписи на вебинар';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
