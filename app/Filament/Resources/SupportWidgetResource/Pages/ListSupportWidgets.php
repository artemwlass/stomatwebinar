<?php

namespace App\Filament\Resources\SupportWidgetResource\Pages;

use App\Filament\Resources\SupportWidgetResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSupportWidgets extends ListRecords
{
    protected static string $resource = SupportWidgetResource::class;

    protected function getHeaderActions(): array
    {
        return [
//            Actions\CreateAction::make(),
        ];
    }
}
