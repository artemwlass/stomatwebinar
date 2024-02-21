<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HeaderAndFooterResource\Pages;
use App\Filament\Resources\HeaderAndFooterResource\RelationManagers;
use App\Models\HeaderAndFooter;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HeaderAndFooterResource extends Resource
{
    protected static ?string $model = HeaderAndFooter::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Header')
                    ->schema([
                        Forms\Components\Repeater::make('menu')->label('Меню')->schema([
                            Forms\Components\TextInput::make('text')->label('Текст'),
                            Forms\Components\TextInput::make('link')->label('Ссылка'),
                            Forms\Components\Toggle::make('blanc')->label('Открывать в новой вкладке')->default(false)
                        ])->columns(2)->columnSpanFull()
                    ])->columns(2),

                Forms\Components\Section::make('Footer')
                    ->schema([
                        Forms\Components\TextInput::make('footer_phone')->label('Телефон')->required(),
                        Forms\Components\TextInput::make('footer_email')->label('Email')->required(),
                    ])->columns(2),

                Forms\Components\Section::make('Социальные сети')
                    ->schema([
                        Forms\Components\TextInput::make('footer_facebook')->label('Facebook')->required(),
                        Forms\Components\TextInput::make('footer_telegram')->label('Telegram')->required(),
                        Forms\Components\TextInput::make('footer_instagram')->label('Instagram')->required(),
                        Forms\Components\TextInput::make('footer_youtube')->label('Youtube')->required(),
                    ])->columns(2),

                Forms\Components\Section::make('Меню Footer')
                    ->schema([
                        Forms\Components\Repeater::make('footer_menu1')->label('Меню footer 1')->schema([
                            Forms\Components\TextInput::make('text')->label('Текст'),
                            Forms\Components\TextInput::make('link')->label('Ссылка'),
                            Forms\Components\Toggle::make('blanc')->label('Открывать в новой вкладке')->default(false)
                        ]),
                        Forms\Components\Repeater::make('footer_menu2')->label('Меню footer 2')->schema([
                            Forms\Components\TextInput::make('text')->label('Текст'),
                            Forms\Components\TextInput::make('link')->label('Ссылка'),
                            Forms\Components\Toggle::make('blanc')->label('Открывать в новой вкладке')->default(false)
                        ])
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('footer_phone')
                    ->label('Header and Footer')
                    ->sortable(false) // Отключаем сортировку для статического текста
                    ->formatStateUsing(function ($record) {
                        return 'Header and Footer'; // Замените на ваш статический текст
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
            'index' => Pages\ListHeaderAndFooters::route('/'),
            'create' => Pages\CreateHeaderAndFooter::route('/create'),
            'edit' => Pages\EditHeaderAndFooter::route('/{record}/edit'),
        ];
    }
}
