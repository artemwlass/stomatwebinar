<?php

namespace App\Filament\Resources\HeaderAndFooterResource\Pages;

use App\Filament\Resources\HeaderAndFooterResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHeaderAndFooter extends EditRecord
{
    protected static string $resource = HeaderAndFooterResource::class;

    protected function getHeaderActions(): array
    {
        return [
//            Actions\DeleteAction::make(),
        ];
    }
}
