<?php

namespace App\Filament\Resources\WebinarResource\Pages;

use App\Filament\Resources\WebinarResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWebinars extends ListRecords
{
    protected static string $resource = WebinarResource::class;
    public static ?string $title = 'Вебинары';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
