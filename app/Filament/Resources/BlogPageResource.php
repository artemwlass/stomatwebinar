<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlogPageResource\Pages;
use App\Filament\Resources\BlogPageResource\RelationManagers;
use App\Models\BlogPage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BlogPageResource extends Resource
{
    protected static ?string $model = BlogPage::class;
    protected static ?string $navigationLabel = 'Страница блога';
    protected static ?string $navigationGroup = 'Блог';
    protected static ?string $breadcrumb = 'Страница блога';
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
                        Forms\Components\RichEditor::make('seo.meta_description')->label('Description')->required(),
                        Forms\Components\RichEditor::make('seo.og_description')->label('Og:Description')->required(),
                        Forms\Components\TextInput::make('seo.keywords')->label('Keywords')->required(),
                        Forms\Components\TextInput::make('seo.og_type')->label('Og:Type')->required(),
                        Forms\Components\TextInput::make('seo.og_url')->label('Og:Url')->required()->columnSpanFull(),
                        Forms\Components\FileUpload::make('seo.og_image')->label('Og:Image')->required(
                        )->columnSpanFull()->directory('seo')
                    ])->columns(2),

                Forms\Components\Section::make('Заголовок')
                    ->schema([
                        Forms\Components\TextInput::make('title')->label('Заголовок')->required(),
                        Forms\Components\RichEditor::make('description')->label('Описание')->required(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\IconColumn::make('seo')->label('SEO')->boolean(),
                Tables\Columns\TextColumn::make('title')->label('Title'),
                Tables\Columns\TextColumn::make('description')->label('Description')->words(10)
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
            'index' => Pages\ListBlogPages::route('/'),
            'create' => Pages\CreateBlogPage::route('/create'),
            'edit' => Pages\EditBlogPage::route('/{record}/edit'),
        ];
    }
}
