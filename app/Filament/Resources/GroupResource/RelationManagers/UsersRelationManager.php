<?php

namespace App\Filament\Resources\GroupResource\RelationManagers;

use App\Http\Controllers\ExchangeDateController;
use App\Models\User;
use Carbon\Carbon;
use Filament\Actions\Imports\ImportColumn;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UsersRelationManager extends RelationManager
{
    protected static string $relationship = 'users';
    protected static ?string $title = 'Обучающиеся';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        $options = [
            Carbon::now()->addDay()->format('Y-m-d') => '1 день',
            Carbon::now()->addDays(3)->format('Y-m-d') => '3 дня',
            Carbon::now()->addWeek()->format('Y-m-d') => '1 неделя',
            Carbon::now()->addMonth()->format('Y-m-d') => '1 месяц',
            'free' => 'Бессрочно',
        ];
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Имя')->searchable(),
                Tables\Columns\TextColumn::make('closed_webinar_date')->label('Дата закрытия вебинара'),
                Tables\Columns\TextColumn::make('phone')->label('Телефон'),
                Tables\Columns\TextColumn::make('city')->label('Город'),
                Tables\Columns\TextColumn::make('email')->searchable()->icon('heroicon-m-envelope')->copyable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\Action::make('periodAllGroup')
                    ->label('Продлить срок действия группе')
                    ->form([
                        Forms\Components\Select::make('periodAllGroup')
                            ->label('Продлить срок действия')
                            ->required()
                            ->options([
                                'one_day' => '1 день',
                                'three_day' => '3 дня',
                                'one_week' => '1 неделя',
                                'one_month' => '1 месяц',
                            ]),
                    ])
                    ->action(function ($data, $livewire): void {
                        $parentRecord = $livewire->getOwnerRecord();
                        $record = $parentRecord->id;
                        $exchange = new ExchangeDateController();
                        switch ($data['periodAllGroup']) {
                            case 'one_day':
                                $exchange->updateClosedWebinarDateAllGroup($record, 1);
                                break;

                            case 'three_day':
                                $exchange->updateClosedWebinarDateAllGroup($record, 3);
                                break;

                            case 'one_week':
                                $exchange->updateClosedWebinarDateAllGroup($record, 7);
                                break;

                            case 'one_month':
                                $exchange->updateClosedWebinarDateAllGroup($record, 30);
                                break;

                            // Можно добавить default case, если это необходимо
                        }
                    }),
                Tables\Actions\AttachAction::make()
                    ->label('Добавить пользователя')
                    ->preloadRecordSelect()
                    ->form(fn(AttachAction $action): array => [
                        $action->getRecordSelect(),
                        Forms\Components\Select::make('closed_webinar_date')
                            ->label('Период')
                            ->required()
                            ->options($options),
                    ])
            ])
            ->actions([
                Tables\Actions\Action::make('period')
                    ->label('Продлить срок действия')
                    ->form([
                        Forms\Components\Select::make('period')
                            ->label('Продлить срок действия')
                            ->required()
                            ->options([
                                'one_day' => '1 день',
                                'three_day' => '3 дня',
                                'one_week' => '1 неделя',
                                'one_month' => '1 месяц',
                                'free' => 'Бессрочно',
                            ]),
                    ])
                    ->action(function ($data, $record): void {
                        $exchange = new ExchangeDateController();
                        switch ($data['period']) {
                            case 'one_day':
                                $exchange->updateClosedWebinarDate($record, 1);
                                break;

                            case 'three_day':
                                $exchange->updateClosedWebinarDate($record, 3);
                                break;

                            case 'one_week':
                                $exchange->updateClosedWebinarDate($record, 7);
                                break;

                            case 'one_month':
                                $exchange->updateClosedWebinarDate($record, 30);
                                break;

                            case 'free':
                                $exchange->freeLector($record);
                                break;

                            // Можно добавить default case, если это необходимо
                        }
                    }),

        Tables\Actions\DetachAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
