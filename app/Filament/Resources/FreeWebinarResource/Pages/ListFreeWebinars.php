<?php

namespace App\Filament\Resources\FreeWebinarResource\Pages;

use App\Filament\Resources\FreeWebinarResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFreeWebinars extends ListRecords
{
    protected static string $resource = FreeWebinarResource::class;
    public static ?string $title = 'Бесплатные вебинары';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
