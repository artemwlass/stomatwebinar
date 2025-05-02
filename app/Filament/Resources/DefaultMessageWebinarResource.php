<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DefaultMessageWebinarResource\Pages;
use App\Filament\Resources\DefaultMessageWebinarResource\RelationManagers;
use App\Models\DefaultMessageWebinar;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DefaultMessageWebinarResource extends Resource
{
    protected static ?string $model = DefaultMessageWebinar::class;

    protected static ?string $navigationLabel = 'Сообщение предзапись (дефолтное)';
    protected static ?string $navigationGroup = 'Вебинары';
    protected static ?string $breadcrumb = 'Сообщение предзапись (дефолтное)';
    protected static ?string $navigationIcon = 'heroicon-o-at-symbol';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\RichEditor::make('message')
                            ->label('Текст сообщения')
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('message')->label('Текст')->limit(50)->html()
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
            'index' => Pages\ListDefaultMessageWebinars::route('/'),
            'create' => Pages\CreateDefaultMessageWebinar::route('/create'),
            'edit' => Pages\EditDefaultMessageWebinar::route('/{record}/edit'),
        ];
    }
}
