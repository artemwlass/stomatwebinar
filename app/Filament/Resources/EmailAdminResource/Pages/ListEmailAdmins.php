<?php

namespace App\Filament\Resources\EmailAdminResource\Pages;

use App\Filament\Resources\EmailAdminResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEmailAdmins extends ListRecords
{
    protected static string $resource = EmailAdminResource::class;
    public static ?string $title = 'Почта менеджеров';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
