<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FreeWebinarPageResource\Pages;
use App\Filament\Resources\FreeWebinarPageResource\RelationManagers;
use App\Models\FreeWebinarPage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FreeWebinarPageResource extends Resource
{
    protected static ?string $model = FreeWebinarPage::class;
    protected static ?string $navigationLabel = 'Страница бесплатных вебинаров';
    protected static ?string $navigationGroup = 'Бесплатные вебинары';
    protected static ?string $breadcrumb = 'Страница бесплатных вебинаров';
    protected static ?string $navigationIcon = 'heroicon-s-computer-desktop';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('SEO')
                    ->schema([
                        Forms\Components\TextInput::make('seo.title')->label('Title')->required(),
                        Forms\Components\TextInput::make('seo.og_title')->label('Og:Title')->required(),
                        Forms\Components\Textarea::make('seo.meta_description')->label(
                            'Description'
                        )->rows(5)->required(),
                        Forms\Components\Textarea::make('seo.og_description')->label(
                            'Og:Description'
                        )->rows(5)->required(),
                        Forms\Components\TextInput::make('seo.keywords')->label('Keywords')->required(),
                        Forms\Components\TextInput::make('seo.og_type')->label('Og:Type')->required(),
                        Forms\Components\TextInput::make('seo.og_url')->label('Og:Url')->required()->columnSpanFull(),
                        Forms\Components\FileUpload::make('seo.og_image')->label('Og:Image')->required(
                        )->columnSpanFull()->directory('seo')
                    ])->columns(2),

                Forms\Components\Section::make('Заголовок')
                    ->schema([
                        Forms\Components\TextInput::make('title')->label('Заголовок')->required(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->label('Title'),
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
            'index' => Pages\ListFreeWebinarPages::route('/'),
            'create' => Pages\CreateFreeWebinarPage::route('/create'),
            'edit' => Pages\EditFreeWebinarPage::route('/{record}/edit'),
        ];
    }
}
