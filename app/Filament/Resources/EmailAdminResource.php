<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmailAdminResource\Pages;
use App\Filament\Resources\EmailAdminResource\RelationManagers;
use App\Models\EmailAdmin;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class EmailAdminResource extends Resource
{
    protected static ?string $model = EmailAdmin::class;
    protected static ?string $navigationLabel = 'Почта для уведомлений';
    protected static ?string $navigationGroup = 'Настройки';
    protected static ?string $breadcrumb = 'Почта для уведомлений';
    protected static ?string $navigationIcon = 'heroicon-o-at-symbol';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Добавление почты')
                    ->schema([
                        Forms\Components\TextInput::make('name')->label('Имя менеджера')->required(),
                        Forms\Components\TextInput::make('email')->label('Почта')->required(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Имя'),
                Tables\Columns\TextColumn::make('email')->label('Почта')->icon('heroicon-m-envelope')->copyable()
                    ->copyMessage('Скопировано'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmailAdmins::route('/'),
            'create' => Pages\CreateEmailAdmin::route('/create'),
            'edit' => Pages\EditEmailAdmin::route('/{record}/edit'),
        ];
    }
}
