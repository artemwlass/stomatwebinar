<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DefaultMessagePurchaseRegistrationResource\Pages;
use App\Models\DefaultMessagePurchaseRegistration;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DefaultMessagePurchaseRegistrationResource extends Resource
{
    protected static ?string $model = DefaultMessagePurchaseRegistration::class;

    protected static ?string $navigationLabel = 'Сообщение регистрация при покупке';
    protected static ?string $navigationGroup = 'Вебинары';
    protected static ?string $breadcrumb = 'Сообщение регистрация при покупке';
    protected static ?string $navigationIcon = 'heroicon-o-at-symbol';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\RichEditor::make('message')
                            ->label('Текст сообщения')
                            ->helperText('Доступные переменные: [NAME], [EMAIL], [PASSWORD]')
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('message')->label('Текст')->limit(50)->html(),
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
            'index' => Pages\ListDefaultMessagePurchaseRegistrations::route('/'),
            'create' => Pages\CreateDefaultMessagePurchaseRegistration::route('/create'),
            'edit' => Pages\EditDefaultMessagePurchaseRegistration::route('/{record}/edit'),
        ];
    }
}
