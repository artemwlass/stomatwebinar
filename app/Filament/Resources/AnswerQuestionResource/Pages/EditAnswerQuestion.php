<?php

namespace App\Filament\Resources\AnswerQuestionResource\Pages;

use App\Filament\Resources\AnswerQuestionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAnswerQuestion extends EditRecord
{
    protected static string $resource = AnswerQuestionResource::class;
    public static ?string $title = 'Редактирование';
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
