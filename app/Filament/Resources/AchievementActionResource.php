<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AchievementActionResource\Pages;
use App\Models\AchievementAction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AchievementActionResource extends Resource
{
    protected static ?string $model = AchievementAction::class;
    protected static ?string $navigationLabel = 'Начисление баллов';
    protected static ?string $pluralModelLabel = 'Начисление баллов';
    protected static ?string $navigationGroup = 'Аккаунт';
    protected static ?string $navigationIcon = 'heroicon-o-sparkles';
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('code')->label('Системный код')->required()->unique(ignoreRecord: true)->disabled(fn ($record) => filled($record))->dehydrated(),
            Forms\Components\TextInput::make('title')->label('Название действия')->required(),
            Forms\Components\TextInput::make('points')->label('Количество баллов')->integer()->minValue(0)->required(),
            Forms\Components\Select::make('icon')->label('Иконка')->options([
                'achievement-point-book.svg' => 'Книга',
                'achievement-point-video.svg' => 'Видео',
                'achievement-point-article-1.svg' => 'Статья',
                'achievement-point-publish.svg' => 'Публикация',
                'achievement-point-coins.svg' => 'Покупка',
            ]),
            Forms\Components\TextInput::make('sort')->label('Сортировка')->integer()->default(0),
            Forms\Components\Toggle::make('is_active')->label('Активно')->default(true),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table->defaultSort('sort')->columns([
            Tables\Columns\TextColumn::make('title')->label('Действие'),
            Tables\Columns\TextColumn::make('code')->label('Код'),
            Tables\Columns\TextColumn::make('points')->label('Баллы')->sortable(),
            Tables\Columns\IconColumn::make('is_active')->label('Активно')->boolean(),
        ])->actions([Tables\Actions\EditAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAchievementActions::route('/'),
            'edit' => Pages\EditAchievementAction::route('/{record}/edit'),
        ];
    }
}
