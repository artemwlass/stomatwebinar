<?php

namespace App\Filament\Resources\AnswerQuestionResource\Pages;

use App\Filament\Resources\AnswerQuestionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAnswerQuestion extends CreateRecord
{
    protected static string $resource = AnswerQuestionResource::class;
    public static ?string $title = 'Создать';
}
