<?php

namespace App\Filament\Resources\DefaultMessageWebinarOrderResource\Pages;

use App\Filament\Resources\DefaultMessageWebinarOrderResource;
use App\Models\DefaultMessageWebinar;
use App\Models\DefaultMessageWebinarOrder;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDefaultMessageWebinarOrders extends ListRecords
{
    protected static string $resource = DefaultMessageWebinarOrderResource::class;
    public static ?string $title = 'Сообщение';

    protected function getHeaderActions(): array
    {
        if (DefaultMessageWebinarOrder::count() > 0) {
            return [];
        } else {
            return [
                Actions\CreateAction::make(),
            ];
        }

    }
}
