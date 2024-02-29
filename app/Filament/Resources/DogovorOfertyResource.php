<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DogovorOfertyResource\Pages;
use App\Filament\Resources\DogovorOfertyResource\RelationManagers;
use App\Models\DogovorOferty;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class DogovorOfertyResource extends Resource
{
    protected static ?string $model = DogovorOferty::class;
    protected static ?string $navigationLabel = 'Договор оферты';
    protected static ?string $navigationGroup = 'Настройки';
    protected static ?string $breadcrumb = 'Договор оферты';
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

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

                Forms\Components\Section::make('Договор')
                    ->schema([
                        Forms\Components\TextInput::make('title')->label('Заголовок')->required(),
                        Forms\Components\RichEditor::make('text')->label('Текст')
                            ->required()

                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->label('Заголовок')
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
            'index' => Pages\ListDogovorOferties::route('/'),
            'create' => Pages\CreateDogovorOferty::route('/create'),
            'edit' => Pages\EditDogovorOferty::route('/{record}/edit'),
        ];
    }
}
