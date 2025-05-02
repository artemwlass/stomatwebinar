<?php

namespace App\Filament\Resources\DefaultMessageWebinarResource\Pages;

use App\Filament\Resources\DefaultMessageWebinarResource;
use App\Models\DefaultMessageWebinar;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDefaultMessageWebinars extends ListRecords
{
    protected static string $resource = DefaultMessageWebinarResource::class;
    public static ?string $title = 'Сообщение';

    protected function getHeaderActions(): array
    {
        if (DefaultMessageWebinar::count() > 0) {
            return [];
        } else {
            return [
                Actions\CreateAction::make(),
            ];
        }

    }
}
