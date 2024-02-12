<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AnswerQuestionResource\Pages;
use App\Filament\Resources\AnswerQuestionResource\RelationManagers;
use App\Models\AnswerQuestion;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AnswerQuestionResource extends Resource
{
    protected static ?string $model = AnswerQuestion::class;
    protected static ?string $navigationLabel = 'Вопрос - Ответ';
    protected static ?string $navigationGroup = 'Настройки';
    protected static ?string $breadcrumb = 'Вопрос - Ответ';
    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Вопрос - Ответ')
                    ->schema([
                        Forms\Components\TextInput::make('question')->label('Вопрос')->required(),
                        Forms\Components\Textarea::make('answer')->label('Ответ')->required()->rows(5),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('question')->label('Вопрос')->sortable()->searchable()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAnswerQuestions::route('/'),
            'create' => Pages\CreateAnswerQuestion::route('/create'),
            'edit' => Pages\EditAnswerQuestion::route('/{record}/edit'),
        ];
    }
}
