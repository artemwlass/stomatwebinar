<?php

namespace App\Filament\Resources\FreeWebinarResource\Pages;

use App\Filament\Resources\FreeWebinarResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateFreeWebinar extends CreateRecord
{
    protected static string $resource = FreeWebinarResource::class;
    public static ?string $title = 'Создать';
}
