<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AchievementLevelResource\Pages;
use App\Filament\Resources\AchievementLevelResource\RelationManagers\GiftsRelationManager;
use App\Models\AchievementLevel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AchievementLevelResource extends Resource
{
    protected static ?string $model = AchievementLevel::class;
    protected static ?string $navigationLabel = 'Уровни и подарки';
    protected static ?string $pluralModelLabel = 'Уровни и подарки';
    protected static ?string $navigationGroup = 'Аккаунт';
    protected static ?string $navigationIcon = 'heroicon-o-gift';
    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title')->label('Название уровня')->required(),
            Forms\Components\TextInput::make('points_required')->label('Необходимо баллов')->integer()->minValue(0)->required(),
            Forms\Components\FileUpload::make('image')->label('Изображение')->image()->disk('public')->directory('achievements/levels')->visibility('public'),
            Forms\Components\TextInput::make('sort')->label('Сортировка')->integer()->default(0),
            Forms\Components\Toggle::make('is_active')->label('Отображать')->default(true),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table->defaultSort('sort')->columns([
            Tables\Columns\TextColumn::make('title')->label('Уровень'),
            Tables\Columns\TextColumn::make('points_required')->label('Баллы')->sortable(),
            Tables\Columns\TextColumn::make('gifts_count')->label('Подарков')->counts('gifts'),
            Tables\Columns\IconColumn::make('is_active')->label('Отображается')->boolean(),
        ])->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ])->bulkActions([
            Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()]),
        ]);
    }

    public static function getRelations(): array { return [GiftsRelationManager::class]; }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAchievementLevels::route('/'),
            'create' => Pages\CreateAchievementLevel::route('/create'),
            'edit' => Pages\EditAchievementLevel::route('/{record}/edit'),
        ];
    }
}
