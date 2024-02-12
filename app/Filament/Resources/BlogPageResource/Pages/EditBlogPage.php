<?php

namespace App\Filament\Resources\BlogPageResource\Pages;

use App\Filament\Resources\BlogPageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBlogPage extends EditRecord
{
    protected static string $resource = BlogPageResource::class;
    public static ?string $title = 'Страница блога - Редактирование';

    protected function getHeaderActions(): array
    {
        return [
//            Actions\DeleteAction::make(),
        ];
    }
}
