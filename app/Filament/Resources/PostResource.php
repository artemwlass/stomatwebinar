<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use FilamentTiptapEditor\TiptapEditor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;
    protected static ?string $navigationLabel = 'Статьи';
    protected static ?string $navigationGroup = 'Блог';
    protected static ?string $breadcrumb = 'Статьи';
    protected static ?string $navigationIcon = 'heroicon-m-document-text';
    protected static ?int $navigationSort = 2;

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

                Forms\Components\Section::make('Пост')
                ->schema([
                    Forms\Components\FileUpload::make('image')->label('Изображение')->directory('blog')->required()->columnSpanFull(),
                    Forms\Components\TextInput::make('title')
                        ->label('Название')
                        ->maxLength('255')
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(
                            fn (string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set(
                                'slug',
                                Str::slug($state)
                            ) : null
                        ),
                    Forms\Components\TextInput::make('slug')
                        ->label('URL')
                        ->disabled()
                        ->dehydrated()
                        ->required()
                        ->unique(Post::class, 'slug', ignoreRecord: true),
                ])->columns(2),

                Forms\Components\Section::make('Текст')
                ->schema([
                    TinyEditor::make('text')->fileAttachmentsDirectory('blog')->maxHeight(500),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')->label('Изоброжение'),
                Tables\Columns\TextColumn::make('title')->label('Названия')->sortable()->searchable()
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
