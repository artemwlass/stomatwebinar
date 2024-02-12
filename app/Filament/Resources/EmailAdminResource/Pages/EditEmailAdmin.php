<?php

namespace App\Filament\Resources\EmailAdminResource\Pages;

use App\Filament\Resources\EmailAdminResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEmailAdmin extends EditRecord
{
    protected static string $resource = EmailAdminResource::class;
    public static ?string $title = 'Редактирование';

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
