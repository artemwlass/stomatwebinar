<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentAttemptResource\Pages;
use App\Models\PaymentAttempt;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PaymentAttemptResource extends Resource
{
    protected static ?string $model = PaymentAttempt::class;

    protected static ?string $navigationLabel = 'Попытки оплат';
    protected static ?string $navigationGroup = 'Продажи';
    protected static ?string $breadcrumb = 'Попытки оплат';
    protected static ?string $navigationIcon = 'heroicon-o-credit-card';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Статус и суммы')
                    ->schema([
                        TextEntry::make('status')
                            ->label('Статус')
                            ->badge()
                            ->formatStateUsing(fn (?string $state): string => match ($state) {
                                'paid' => 'Оплачено',
                                'failed' => 'Неуспешно',
                                default => 'Ожидает',
                            })
                            ->color(fn (?string $state): string => match ($state) {
                                'paid' => 'success',
                                'failed' => 'danger',
                                default => 'warning',
                            }),
                        TextEntry::make('amount')->label('Сумма')->money('UAH'),
                        TextEntry::make('currency')->label('Валюта'),
                        TextEntry::make('order_id')->label('ID заказа')->placeholder('-'),
                        TextEntry::make('liqpay_order_id')->label('LiqPay Order ID'),
                        TextEntry::make('payment_token')->label('Payment token'),
                    ])
                    ->columns(2),
                Section::make('Клиент')
                    ->schema([
                        TextEntry::make('user_name')->label('Имя'),
                        TextEntry::make('user_surname')->label('Фамилия'),
                        TextEntry::make('user_email')->label('Email'),
                        TextEntry::make('user_phone')->label('Телефон'),
                        TextEntry::make('user_id')->label('User ID')->placeholder('-'),
                    ])
                    ->columns(2),
                Section::make('Временные метки')
                    ->schema([
                        TextEntry::make('created_at')->label('Создано')->dateTime('d.m.Y H:i:s'),
                        TextEntry::make('paid_at')->label('Оплачено')->dateTime('d.m.Y H:i:s')->placeholder('-'),
                        TextEntry::make('failed_at')->label('Неуспешно')->dateTime('d.m.Y H:i:s')->placeholder('-'),
                        TextEntry::make('failed_reason')->label('Причина')->placeholder('-'),
                    ])
                    ->columns(2),
                Section::make('Корзина')
                    ->schema([
                        TextEntry::make('cart_data_pretty')
                            ->label('Данные корзины')
                            ->state(fn (PaymentAttempt $record): string => json_encode($record->cart_data ?? [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT))
                            ->columnSpanFull(),
                    ]),
                Section::make('Callback LiqPay')
                    ->schema([
                        TextEntry::make('callback_payload_pretty')
                            ->label('Payload')
                            ->state(fn (PaymentAttempt $record): string => json_encode($record->callback_payload ?? [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT))
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('ID')->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Статус')
                    ->badge()
                    ->colors([
                        'warning' => 'pending',
                        'danger' => 'failed',
                        'success' => 'paid',
                    ])
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'paid' => 'Оплачено',
                        'failed' => 'Неуспешно',
                        default => 'Ожидает',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('amount')
                    ->label('Сумма')
                    ->money('UAH')
                    ->sortable(),
                Tables\Columns\TextColumn::make('user_name')
                    ->label('Имя')
                    ->formatStateUsing(fn ($state, PaymentAttempt $record) => trim(($record->user_name ?? '') . ' ' . ($record->user_surname ?? '')))
                    ->searchable(['user_name', 'user_surname']),
                Tables\Columns\TextColumn::make('user_email')
                    ->label('Email')
                    ->icon('heroicon-m-envelope')
                    ->copyable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('user_phone')
                    ->label('Телефон')
                    ->copyable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('liqpay_order_id')
                    ->label('LiqPay Order ID')
                    ->copyable()
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('order_id')
                    ->label('Заказ ID')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('failed_reason')
                    ->label('Причина')
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('paid_at')
                    ->label('Оплачен')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Создан')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Статус')
                    ->options([
                        'pending' => 'Ожидает',
                        'failed' => 'Неуспешно',
                        'paid' => 'Оплачено',
                    ]),
                SelectFilter::make('unpaid')
                    ->label('Не оплачено')
                    ->options([
                        '1' => 'Только не оплаченные',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        if (($data['value'] ?? null) !== '1') {
                            return $query;
                        }

                        return $query->whereIn('status', ['pending', 'failed']);
                    }),
                Filter::make('created_at')
                    ->label('Дата попытки')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')->label('С'),
                        Forms\Components\DatePicker::make('created_until')->label('По'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'] ?? null,
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'] ?? null,
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
                SelectFilter::make('has_order')
                    ->label('Связь с заказом')
                    ->options([
                        'yes' => 'Есть order_id',
                        'no' => 'Без order_id',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return match ($data['value'] ?? null) {
                            'yes' => $query->whereNotNull('order_id'),
                            'no' => $query->whereNull('order_id'),
                            default => $query,
                        };
                    }),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\ViewAction::make()->label('Просмотр'),
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
            'index' => Pages\ListPaymentAttempts::route('/'),
            'view' => Pages\ViewPaymentAttempt::route('/{record}'),
        ];
    }
}
