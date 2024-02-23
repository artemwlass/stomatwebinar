<?php

namespace App\Filament\Resources\FreeWebinarPreorderResource\Pages;

use App\Filament\Resources\FreeWebinarPreorderResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFreeWebinarPreorders extends ListRecords
{
    protected static string $resource = FreeWebinarPreorderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
