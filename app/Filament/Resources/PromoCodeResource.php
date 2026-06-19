<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PromoCodeResource\Pages;
use App\Models\PromoCode;
use Filament\Forms;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PromoCodeResource extends Resource
{
    protected static ?string $model = PromoCode::class;
    protected static ?string $navigationLabel = 'Промокоды';
    protected static ?string $navigationGroup = 'Настройки';
    protected static ?string $breadcrumb = 'Промокоды';
    protected static ?string $navigationIcon = 'heroicon-o-ticket';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Промокод')
                    ->schema([
                        Forms\Components\TextInput::make('code')
                            ->label('Код')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->dehydrateStateUsing(fn (?string $state): string => mb_strtoupper(trim((string) $state))),

                        Forms\Components\Select::make('discount_type')
                            ->label('Тип скидки')
                            ->options([
                                'fixed' => 'Фиксированная сумма, грн',
                                'percent' => 'Процент',
                            ])
                            ->required()
                            ->native(false),

                        Forms\Components\TextInput::make('discount_value')
                            ->label('Размер скидки')
                            ->numeric()
                            ->minValue(0)
                            ->required()
                            ->suffix(fn (Get $get): string => $get('discount_type') === 'percent' ? '%' : 'грн'),

                        Forms\Components\Select::make('validity_days')
                            ->label('Срок действия')
                            ->options([
                                1 => '1 день',
                                3 => '3 дня',
                                7 => '7 дней',
                                30 => '30 дней',
                                'forever' => 'Бессрочно',
                            ])
                            ->default('forever')
                            ->native(false)
                            ->dehydrateStateUsing(fn ($state) => $state === 'forever' ? null : (int) $state),

                        Forms\Components\DateTimePicker::make('expires_at')
                            ->label('Действует до')
                            ->seconds(false)
                            ->helperText('Заполняется автоматически по сроку действия. Можно вручную изменить при редактировании.'),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Активен')
                            ->default(true),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->label('Код')
                    ->searchable()
                    ->copyable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('discount_type')
                    ->label('Тип')
                    ->formatStateUsing(fn (string $state): string => $state === 'percent' ? 'Процент' : 'Фикс'),
                Tables\Columns\TextColumn::make('discount_value')
                    ->label('Скидка')
                    ->formatStateUsing(fn ($state, PromoCode $record): string => $record->discount_type === 'percent'
                        ? rtrim(rtrim(number_format((float) $state, 2, '.', ''), '0'), '.') . '%'
                        : number_format((float) $state, 2, '.', ' ') . ' грн'),
                Tables\Columns\TextColumn::make('expires_at')
                    ->label('Действует до')
                    ->dateTime('d.m.Y H:i')
                    ->placeholder('Бессрочно'),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Активен')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Создан')
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPromoCodes::route('/'),
            'create' => Pages\CreatePromoCode::route('/create'),
            'edit' => Pages\EditPromoCode::route('/{record}/edit'),
        ];
    }
}
