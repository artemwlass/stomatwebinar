<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MessagePreorderWebinarFreeResource\Pages;
use App\Filament\Resources\MessagePreorderWebinarFreeResource\RelationManagers;
use App\Models\MessagePreorderWebinarFree;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MessagePreorderWebinarFreeResource extends Resource
{
    protected static ?string $model = MessagePreorderWebinarFree::class;

    protected static ?string $navigationLabel = 'Сообщение на почту';
    protected static ?string $navigationGroup = 'Предзапись на вебинар';
    protected static ?string $breadcrumb = 'Сообщение на почту';
    protected static ?string $navigationIcon = 'heroicon-o-at-symbol';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                ->schema([
                    Forms\Components\RichEditor::make('text')
                    ->label('Текст сообщения')
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('text')->label('Текст')->limit(50)->html()
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
            'index' => Pages\ListMessagePreorderWebinarFrees::route('/'),
            'create' => Pages\CreateMessagePreorderWebinarFree::route('/create'),
            'edit' => Pages\EditMessagePreorderWebinarFree::route('/{record}/edit'),
        ];
    }
}
