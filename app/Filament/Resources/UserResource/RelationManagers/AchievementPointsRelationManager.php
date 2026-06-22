<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use App\Support\AchievementPoints;
use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class AchievementPointsRelationManager extends RelationManager
{
    protected static string $relationship = 'achievementPointTransactions';
    protected static ?string $title = 'История баллов';

    public function table(Table $table): Table
    {
        return $table->defaultSort('created_at', 'desc')->columns([
            Tables\Columns\TextColumn::make('description')->label('Операция')->wrap(),
            Tables\Columns\TextColumn::make('points')->label('Баллы')->color(fn ($state) => $state >= 0 ? 'success' : 'danger')->formatStateUsing(fn ($state) => ($state > 0 ? '+' : '') . $state),
            Tables\Columns\TextColumn::make('created_at')
                ->label('Дата')
                ->formatStateUsing(fn ($state): string => $state
                    ? $state->copy()->timezone(config('app.display_timezone'))->format('d.m.Y H:i')
                    : '—'),
        ])->headerActions([
            Tables\Actions\Action::make('adjust')
                ->label('Начислить / списать')
                ->icon('heroicon-o-adjustments-horizontal')
                ->form([
                    Forms\Components\TextInput::make('points')->label('Баллы')->integer()->required()->helperText('Положительное число начисляет, отрицательное списывает.'),
                    Forms\Components\TextInput::make('description')->label('Причина')->required()->maxLength(255),
                ])
                ->action(fn (array $data) => AchievementPoints::adjust($this->getOwnerRecord(), (int) $data['points'], $data['description'])),
        ])->actions([Tables\Actions\DeleteAction::make()]);
    }
}
