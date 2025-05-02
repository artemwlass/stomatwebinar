<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DefaultMessageWebinarOrderResource\Pages;
use App\Filament\Resources\DefaultMessageWebinarOrderResource\RelationManagers;
use App\Models\DefaultMessageWebinarOrder;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DefaultMessageWebinarOrderResource extends Resource
{
    protected static ?string $model = DefaultMessageWebinarOrder::class;

    protected static ?string $navigationLabel = 'Сообщение покупка (дефолтное)';
    protected static ?string $navigationGroup = 'Вебинары';
    protected static ?string $breadcrumb = 'Сообщение покупка (дефолтное)';
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
            'index' => Pages\ListDefaultMessageWebinarOrders::route('/'),
            'create' => Pages\CreateDefaultMessageWebinarOrder::route('/create'),
            'edit' => Pages\EditDefaultMessageWebinarOrder::route('/{record}/edit'),
        ];
    }
}
