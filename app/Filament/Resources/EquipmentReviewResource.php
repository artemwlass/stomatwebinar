<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EquipmentReviewResource\Pages;
use App\Models\EquipmentReview;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class EquipmentReviewResource extends Resource
{
    protected static ?string $model = EquipmentReview::class;
    protected static ?string $navigationLabel = 'Обзоры оборудования';
    protected static ?string $modelLabel = 'обзор оборудования';
    protected static ?string $pluralModelLabel = 'Обзоры оборудования';
    protected static ?string $navigationGroup = 'Аккаунт';
    protected static ?string $navigationIcon = 'heroicon-o-video-camera';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Заявка')
                ->schema([
                    Forms\Components\Select::make('user_id')
                        ->label('Пользователь')
                        ->relationship('user', 'email')
                        ->searchable()
                        ->preload()
                        ->required(),
                    Forms\Components\TextInput::make('phone')->label('Телефон')->required()->maxLength(100),
                    Forms\Components\TextInput::make('email')->label('Email')->email()->required(),
                    Forms\Components\TextInput::make('video_url')
                        ->label('Ссылка на видео от пользователя')
                        ->url()
                        ->required()
                        ->suffixAction(
                            Forms\Components\Actions\Action::make('openVideoUrl')
                                ->icon('heroicon-m-arrow-top-right-on-square')
                                ->url(fn (?EquipmentReview $record): ?string => $record?->video_url)
                                ->openUrlInNewTab()
                        )
                        ->columnSpanFull(),
                    Forms\Components\FileUpload::make('video_file')
                        ->label('Видео для публикации')
                        ->helperText('Скачайте видео по ссылке выше и загрузите его сюда. Без файла публикация недоступна.')
                        ->disk('public')
                        ->directory('equipment/videos')
                        ->visibility('public')
                        ->acceptedFileTypes(['video/mp4', 'video/quicktime', 'video/webm'])
                        ->maxSize(2252800)
                        ->openable()
                        ->downloadable()
                        ->live()
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('title')->label('Название')->required()->maxLength(255)->columnSpanFull(),
                    Forms\Components\Textarea::make('review')->label('Развернутый отзыв')->rows(8)->required()->columnSpanFull(),
                    Forms\Components\FileUpload::make('cover_image')
                        ->label('Обложка')
                        ->image()
                        ->disk('public')
                        ->directory('equipment')
                        ->visibility('public')
                        ->openable()
                        ->columnSpanFull(),
                ])->columns(2),

            Forms\Components\Section::make('Публикация')
                ->schema([
                    Forms\Components\Toggle::make('is_approved')
                        ->label('Подтвердить публикацию')
                        ->helperText('После включения обзор станет доступен всем пользователям. Сначала загрузите видео.')
                        ->disabled(fn (Forms\Get $get): bool => blank($get('video_file'))),
                    Forms\Components\DateTimePicker::make('approved_at')
                        ->label('Дата подтверждения')
                        ->seconds(false)
                        ->disabled()
                        ->dehydrated(false),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('title')->label('Название')->searchable()->sortable()->limit(50),
                Tables\Columns\TextColumn::make('email')->label('Email')->searchable(),
                Tables\Columns\IconColumn::make('is_approved')->label('Подтвержден')->boolean(),
                Tables\Columns\IconColumn::make('video_file')
                    ->label('Видео загружено')
                    ->boolean(fn (?string $state): bool => filled($state)),
                Tables\Columns\TextColumn::make('created_at')->label('Отправлен')->dateTime('d.m.Y H:i')->sortable(),
                Tables\Columns\TextColumn::make('approved_at')->label('Опубликован')->dateTime('d.m.Y H:i')->placeholder('Ожидает'),
            ])
            ->actions([
                Tables\Actions\Action::make('approve')
                    ->label('Подтвердить')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (EquipmentReview $record): bool => ! $record->is_approved)
                    ->action(function (EquipmentReview $record): void {
                        if (! $record->video_file) {
                            Notification::make()
                                ->title('Сначала загрузите видео')
                                ->body('Откройте заявку, скачайте видео по ссылке пользователя и загрузите файл.')
                                ->warning()
                                ->send();

                            return;
                        }

                        $record->is_approved = true;
                        $record->save();
                    }),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEquipmentReviews::route('/'),
            'create' => Pages\CreateEquipmentReview::route('/create'),
            'edit' => Pages\EditEquipmentReview::route('/{record}/edit'),
        ];
    }
}
