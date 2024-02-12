<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SupportWidgetResource\Pages;
use App\Filament\Resources\SupportWidgetResource\RelationManagers;
use App\Models\SupportWidget;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class SupportWidgetResource extends Resource
{
    protected static ?string $model = SupportWidget::class;
    protected static ?string $navigationLabel = 'Support';
    protected static ?string $navigationGroup = 'Настройки';
    protected static ?string $breadcrumb = 'Support';
    protected static ?string $navigationIcon = 'heroicon-o-wrench';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Социальные сети')
                    ->schema([
                        Forms\Components\TextInput::make('viber')->label('Viber')->required(),
                        Forms\Components\TextInput::make('whatsup')->label('WhatsApp')->required(),
                        Forms\Components\TextInput::make('telegram')->label('Telegram')->required(),
                    ]),

                Forms\Components\Section::make('Текст')
                    ->schema([
                        TinyEditor::make('text')->label('Текст')->required(),
                    ]),

                Forms\Components\Section::make('Изображение')
                    ->schema([
                        Forms\Components\FileUpload::make('image1')->label('Изображения на компьютере')->required(),
                        Forms\Components\FileUpload::make('image2')->label('Изображения на планшете')->required(),
                        Forms\Components\FileUpload::make('image3')->label('Изображения на телефоне')->required(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('viber')
                    ->label('Support')
                    ->sortable(false) // Отключаем сортировку для статического текста
                    ->formatStateUsing(function ($record) {
                        return 'Support'; // Замените на ваш статический текст
                    }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSupportWidgets::route('/'),
            'create' => Pages\CreateSupportWidget::route('/create'),
            'edit' => Pages\EditSupportWidget::route('/{record}/edit'),
        ];
    }
}
