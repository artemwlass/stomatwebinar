<?php

namespace App\Filament\Resources\SupportWidgetResource\Pages;

use App\Filament\Resources\SupportWidgetResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSupportWidget extends EditRecord
{
    protected static string $resource = SupportWidgetResource::class;

    protected function getHeaderActions(): array
    {
        return [
//            Actions\DeleteAction::make(),
        ];
    }
}
