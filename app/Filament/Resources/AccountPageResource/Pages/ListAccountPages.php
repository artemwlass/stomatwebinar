<?php

namespace App\Filament\Resources\AccountPageResource\Pages;

use App\Filament\Resources\AccountPageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAccountPages extends ListRecords
{
    protected static string $resource = AccountPageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->visible(fn () => static::getResource()::getModel()::query()->count() === 0),
        ];
    }
}
