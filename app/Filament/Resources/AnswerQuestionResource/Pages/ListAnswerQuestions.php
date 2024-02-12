<?php

namespace App\Filament\Resources\AnswerQuestionResource\Pages;

use App\Filament\Resources\AnswerQuestionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAnswerQuestions extends ListRecords
{
    protected static string $resource = AnswerQuestionResource::class;
    public static ?string $title = 'Вопрос - Ответ';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
