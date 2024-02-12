<?php

namespace App\Filament\Resources\DogovorOfertyResource\Pages;

use App\Filament\Resources\DogovorOfertyResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDogovorOferties extends ListRecords
{
    protected static string $resource = DogovorOfertyResource::class;
    public static ?string $title = 'Договор оферты';

    protected function getHeaderActions(): array
    {
        return [
//            Actions\CreateAction::make(),
        ];
    }
}
