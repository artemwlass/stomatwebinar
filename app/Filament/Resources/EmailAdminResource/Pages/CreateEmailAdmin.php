<?php

namespace App\Filament\Resources\EmailAdminResource\Pages;

use App\Filament\Resources\EmailAdminResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateEmailAdmin extends CreateRecord
{
    protected static string $resource = EmailAdminResource::class;
    public static ?string $title = 'Добавление адреса';
}
