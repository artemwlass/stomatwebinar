<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClinicalCaseResource\Pages;
use App\Filament\Resources\ClinicalCaseResource\RelationManagers\CommentsRelationManager;
use App\Models\ClinicalCase;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ClinicalCaseResource extends Resource
{
    protected static ?string $model = ClinicalCase::class;
    protected static ?string $navigationLabel = 'Кейсы';
    protected static ?string $modelLabel = 'кейс';
    protected static ?string $pluralModelLabel = 'Кейсы';
    protected static ?string $navigationGroup = 'Аккаунт';
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Публикация')
                ->schema([
                    Forms\Components\Select::make('user_id')
                        ->label('Пользователь')
                        ->relationship('user', 'email')
                        ->searchable()
                        ->preload()
                        ->required(),
                    Forms\Components\TextInput::make('author_name')
                        ->label('Автор')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('title')
                        ->label('Название')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('slug')
                        ->label('URL')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(255),
                    Forms\Components\DateTimePicker::make('published_at')
                        ->label('Дата публикации')
                        ->seconds(false)
                        ->default(now())
                        ->required(),
                ])->columns(2),

            Forms\Components\Section::make('Данные пациента')
                ->schema([
                    Forms\Components\TextInput::make('gender')->label('Пол')->maxLength(100),
                    Forms\Components\TextInput::make('age')->label('Возраст')->numeric()->minValue(0)->maxValue(120),
                    Forms\Components\Textarea::make('complaints')->label('Жалобы')->rows(3)->columnSpanFull(),
                    Forms\Components\Textarea::make('medical_history')->label('Общесоматический анамнез')->rows(3)->columnSpanFull(),
                    Forms\Components\Textarea::make('examination')->label('Обследование')->rows(3)->columnSpanFull(),
                ])->columns(2),

            Forms\Components\Section::make('Содержание')
                ->schema([
                    Forms\Components\Textarea::make('content')
                        ->label('Текст кейса')
                        ->rows(14)
                        ->required()
                        ->columnSpanFull(),
                    Forms\Components\FileUpload::make('media')
                        ->label('Фото и видео')
                        ->disk('public')
                        ->directory('casey')
                        ->visibility('public')
                        ->multiple()
                        ->reorderable()
                        ->openable()
                        ->downloadable()
                        ->maxFiles(20)
                        ->maxSize(2252800)
                        ->acceptedFileTypes([
                            'image/jpeg',
                            'image/png',
                            'image/webp',
                            'image/gif',
                            'video/mp4',
                            'video/quicktime',
                            'video/webm',
                        ])
                        ->columnSpanFull(),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('published_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Название')
                    ->searchable()
                    ->sortable()
                    ->limit(60),
                Tables\Columns\TextColumn::make('author_name')
                    ->label('Автор')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.email')
                    ->label('Пользователь')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('comments_count')
                    ->label('Комментарии')
                    ->counts('comments'),
                Tables\Columns\TextColumn::make('published_at')
                    ->label('Опубликован')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            CommentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClinicalCases::route('/'),
            'create' => Pages\CreateClinicalCase::route('/create'),
            'edit' => Pages\EditClinicalCase::route('/{record}/edit'),
        ];
    }
}
