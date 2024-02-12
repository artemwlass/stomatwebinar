<?php

namespace App\Filament\Resources\FreeWebinarPageResource\Pages;

use App\Filament\Resources\FreeWebinarPageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFreeWebinarPages extends ListRecords
{
    protected static string $resource = FreeWebinarPageResource::class;
    public static ?string $title = 'Страница бесплатных вебинаров';

    protected function getHeaderActions(): array
    {
        return [
//            Actions\CreateAction::make(),
        ];
    }
}
