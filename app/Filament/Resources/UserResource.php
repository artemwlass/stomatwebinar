<?php

namespace App\Filament\Resources;

use App\Exports\UsersExport;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\ViewAction;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Maatwebsite\Excel\Facades\Excel;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationLabel = 'Пользователи';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        TextInput::make('name')->label('Имя'),
                        TextInput::make('surname')->label('Фамилия'),
                        TextInput::make('email')->label('Почта'),
                        TextInput::make('phone')->label('Телефон'),
                        TextInput::make('city')->label('Город')->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->columnSpan(['lg' => fn (?User $record) => $record === null ? 3 : 2]),

                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Placeholder::make('created_at')
                            ->label('Дата регистрации')
                            ->content(fn (User $record): ?string => $record->created_at?->diffForHumans()),

                        Forms\Components\Placeholder::make('online')
                            ->label('Последний раз в сети')
                            ->content(fn (User $record): ?string =>  $record->online ? \Carbon\Carbon::parse($record->online)->diffForHumans() : "Еще не входил"),

                    ])
                    ->columnSpan(['lg' => 1])
                    ->hidden(fn (?User $record) => $record === null),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Имя')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('email')->searchable()->icon('heroicon-m-envelope')->copyable(
                )->sortable(),
                Tables\Columns\TextColumn::make('created_at')->label('Дата регистрации')->sortable(),
                Tables\Columns\TextColumn::make('online')->label('Был в сети')->sortable()->placeholder('Еще не входил')
                    ->formatStateUsing(
                        fn($state) => $state ? \Carbon\Carbon::parse($state)->diffForHumans() : "Еще не входил"
                    )
            ])
            ->filters([
                //
            ])
            ->defaultSort('created_at', 'desc')
            ->headerActions([
                Tables\Actions\Action::make('Export')
                    ->action(function () {
                        return Excel::download(new UsersExport, 'users.xlsx');
                    })->color('warning'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Просмотр')->icon('heroicon-m-eye'),
            ]);
//            ->bulkActions([
//                Tables\Actions\BulkActionGroup::make([
//                    Tables\Actions\DeleteBulkAction::make(),
//                ]),
//            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\GroupsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
