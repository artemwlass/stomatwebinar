<?php

namespace App\Filament\Resources\AchievementLevelResource\RelationManagers;

use App\Models\AchievementGift;
use Filament\Forms;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class GiftsRelationManager extends RelationManager
{
    protected static string $relationship = 'gifts';
    protected static ?string $title = 'Подарки уровня';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title')->label('Название подарка')->required()->columnSpanFull(),
            Forms\Components\Select::make('gift_type')->label('Тип')->options([
                'webinar_discount' => 'Знижка на вебінар',
                'partner' => 'Сайт партнера',
            ])->required()->live()->native(false),
            Forms\Components\TextInput::make('code')->label('Промокод')->required()->unique(AchievementGift::class, 'code', ignoreRecord: true)
                ->dehydrateStateUsing(fn (?string $state) => mb_strtoupper(trim((string) $state))),
            Forms\Components\Select::make('discount_type')->label('Тип скидки')->options(['fixed' => 'Фикс, грн', 'percent' => 'Процент'])
                ->visible(fn (Get $get) => $get('gift_type') === 'webinar_discount')->required(fn (Get $get) => $get('gift_type') === 'webinar_discount'),
            Forms\Components\TextInput::make('discount_value')->label('Размер скидки')->numeric()->minValue(0)
                ->visible(fn (Get $get) => $get('gift_type') === 'webinar_discount')->required(fn (Get $get) => $get('gift_type') === 'webinar_discount'),
            Forms\Components\TextInput::make('partner_url')->label('Сайт партнера')->url()
                ->visible(fn (Get $get) => $get('gift_type') === 'partner')->required(fn (Get $get) => $get('gift_type') === 'partner')->columnSpanFull(),
            Forms\Components\TextInput::make('validity_days')->label('Срок действия, дней')->integer()->minValue(1)->placeholder('Бессрочно'),
            Forms\Components\TextInput::make('sort')->label('Сортировка')->integer()->default(0),
            Forms\Components\Select::make('image')
                ->label('Изображение подарка')
                ->options([
                    'account_assets/images/modal-prize-1.png' => sprintf(
                        '<div style="display:flex;align-items:center;gap:12px"><img src="%s" style="width:52px;height:52px;object-fit:contain">Ваучер</div>',
                        asset('account_assets/images/modal-prize-1.png')
                    ),
                    'account_assets/images/modal-prize-2.png' => sprintf(
                        '<div style="display:flex;align-items:center;gap:12px"><img src="%s" style="width:52px;height:52px;object-fit:contain">Скидка</div>',
                        asset('account_assets/images/modal-prize-2.png')
                    ),
                ])
                ->allowHtml()
                ->native(false)
                ->required()
                ->columnSpanFull(),
            Forms\Components\Textarea::make('description')->label('Описание и условия')->rows(4)->columnSpanFull(),
            Forms\Components\Toggle::make('is_active')->label('Отображать')->default(true),
        ])->columns(2);
    }

    public function table(Table $table): Table
    {
        return $table->defaultSort('sort')->columns([
            Tables\Columns\TextColumn::make('title')->label('Подарок'),
            Tables\Columns\TextColumn::make('gift_type')->label('Тип')->formatStateUsing(fn ($state) => $state === 'webinar_discount' ? 'Знижка на вебінар' : 'Партнер'),
            Tables\Columns\ImageColumn::make('image')
                ->label('Картинка')
                ->getStateUsing(fn (AchievementGift $record): string => $record->image && ! str_starts_with($record->image, 'account_assets/')
                    ? asset('storage/' . $record->image)
                    : asset($record->image ?: 'account_assets/images/modal-prize-1.png'))
                ->circular(),
            Tables\Columns\TextColumn::make('code')->label('Код')->copyable(),
            Tables\Columns\IconColumn::make('is_active')->label('Показывать')->boolean(),
        ])->headerActions([Tables\Actions\CreateAction::make()])->actions([
            Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make(),
        ]);
    }
}
