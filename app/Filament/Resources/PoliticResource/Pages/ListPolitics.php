<?php

namespace App\Filament\Resources\PoliticResource\Pages;

use App\Filament\Resources\PoliticResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPolitics extends ListRecords
{
    protected static string $resource = PoliticResource::class;
    public static ?string $title = 'Политика';

    protected function getHeaderActions(): array
    {
        return [
//            Actions\CreateAction::make(),
        ];
    }
}
