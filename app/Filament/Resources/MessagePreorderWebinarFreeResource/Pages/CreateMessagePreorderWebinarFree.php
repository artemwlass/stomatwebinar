<?php

namespace App\Filament\Resources\MessagePreorderWebinarFreeResource\Pages;

use App\Filament\Resources\MessagePreorderWebinarFreeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMessagePreorderWebinarFree extends CreateRecord
{
    protected static string $resource = MessagePreorderWebinarFreeResource::class;
    public static ?string $title = 'Создать';
}
