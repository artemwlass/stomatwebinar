<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use App\Events\SendEmailOpenWebinarFromAdmin;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GroupsRelationManager extends RelationManager
{
    protected static string $relationship = 'groups';
    protected static ?string $title = 'Состоит в группах:';

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
                Tables\Columns\TextColumn::make('name'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->label('Добавить в группу')
                    ->preloadRecordSelect()
                    ->form(fn(AttachAction $action): array => [
                        $action->getRecordSelect(),
                        Forms\Components\Select::make('closed_webinar_date')
                            ->label('Период')
                            ->required()
                            ->options($options),
                    ])
                    ->after(function ($record,$data) {
                        event(new SendEmailOpenWebinarFromAdmin($this->getOwnerRecord()));
                    })
            ])
            ->actions([
                Tables\Actions\DetachAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
