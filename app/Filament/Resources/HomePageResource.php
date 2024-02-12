<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HomePageResource\Pages;
use App\Filament\Resources\HomePageResource\RelationManagers;
use App\Models\HomePage;
use Faker\Core\File;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class HomePageResource extends Resource
{
    protected static ?string $model = HomePage::class;
    protected static ?string $navigationLabel = 'Главная страница';
    protected static ?string $navigationGroup = 'Главная';
    protected static ?string $breadcrumb = 'Главная страница';
    protected static ?string $navigationIcon = 'heroicon-s-computer-desktop';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Tabs')
                    ->tabs([
                        Tabs\Tab::make('SEO')
                            ->schema([
                                Forms\Components\Section::make('SEO')
                                    ->schema([
                                        Forms\Components\TextInput::make('seo.title')->label('Title')->required(),
                                        Forms\Components\TextInput::make('seo.og_title')->label('Og:Title')->required(),
                                        Forms\Components\RichEditor::make('seo.meta_description')->label(
                                            'Description'
                                        )->required(),
                                        Forms\Components\RichEditor::make('seo.og_description')->label(
                                            'Og:Description'
                                        )->required(),
                                        Forms\Components\TextInput::make('seo.keywords')->label('Keywords')->required(),
                                        Forms\Components\TextInput::make('seo.og_type')->label('Og:Type')->required(),
                                        Forms\Components\TextInput::make('seo.og_url')->label('Og:Url')->required(
                                        )->columnSpanFull(),
                                        Forms\Components\FileUpload::make('seo.og_image')->label('Og:Image')->required(
                                        )->columnSpanFull()->directory('seo')
                                    ])->columns(2),
                            ]),
                        Tabs\Tab::make('Главный блок')
                            ->schema([
                                Forms\Components\Section::make('Главный баннер')
                                    ->schema([
                                        Forms\Components\RichEditor::make('block_hero.title')->label('Заголовок')->required(),
                                        Forms\Components\RichEditor::make('block_hero.description')->label(
                                            'Описание'
                                        )->required(),
                                        Forms\Components\TextInput::make('block_hero.button_title')->label(
                                            'Текст на кнопке'
                                        )->required(),
                                        Forms\Components\TextInput::make('block_hero.button_link')->label('Ссылка')->required(
                                        ),
                                        Forms\Components\TextInput::make('block_hero.card_title')->label('Заголовок на 1 карточке')->required(
                                        ),
                                        Forms\Components\RichEditor::make('block_hero.card_description')->label(
                                            'Описание на 1 карточке'
                                        )->required(),
                                        Forms\Components\TextInput::make('block_hero.card_title2')->label('Заголовок на 2 карточке')->required(
                                        ),
                                        Forms\Components\RichEditor::make('block_hero.card_description2')->label(
                                            'Описание на 2 карточке'
                                        )->required(),
                                        Forms\Components\RichEditor::make('block_hero.right_text')->label('Текст справа')->required(
                                        ),
                                        Forms\Components\FileUpload::make('block_hero.image')->required()->label('Изображение')
                                    ])->columns(2)
                            ]),
                        Tabs\Tab::make('Ближайший вебинар')
                            ->schema([
                                Forms\Components\Toggle::make('block_highlight.is_active')->default(true)->label('Активность')->columnSpanFull(),
                                Forms\Components\FileUpload::make('block_highlight.image_left')->label('Большое изображение')->required(),
                                Forms\Components\FileUpload::make('block_highlight.image_small')->label('Маленькое изображение')->required(),
                                Forms\Components\TextInput::make('block_highlight.title')->label('Заголовок')->required()->columnSpanFull(),
                                Forms\Components\TagsInput::make('block_highlight.tags')->label('Тэги')->required(),
                                Forms\Components\TextInput::make('block_highlight.data')->label('Дата')->required(),
                                Forms\Components\TextInput::make('block_highlight.text_button')->label('Текст на кнопке')->required(),
                                Forms\Components\TextInput::make('block_highlight.link_button')->label('Ссылка')->required(),

                                Forms\Components\TextInput::make('block_highlight.big_text_button')->label('Текс на большой кнопке')->required(),
                                Forms\Components\TextInput::make('block_highlight.big_link_button')->label('Ссылка')->required(),

                            ])->columns(2),

                        Tabs\Tab::make('О нас')
                        ->schema([
                            Forms\Components\Toggle::make('block_about.is_active')->default(true)->label('Активность')->columnSpanFull(),
                            TinyEditor::make('block_about.text')->label('')->required()->columnSpanFull(),
                            Forms\Components\FileUpload::make('block_about.image_left')->label('Большое изображение')->required(),
                            Forms\Components\FileUpload::make('block_about.image_small')->label('Маленькое изображение')->required(),
                        ])->columns(2),

                        Tabs\Tab::make('Расписание вебинаров')
                            ->schema([
                                Forms\Components\Toggle::make('schedule_webinar.is_active')->default(true)->label('Активность')->columnSpanFull(),
                                Repeater::make('schedule_webinar.data')
                                    ->disableLabel()
                                    ->schema([
                                        Forms\Components\TextInput::make('data')->label('Дата')->required(),
                                        Forms\Components\TextInput::make('text')->label('Название')->required(),
                                        Forms\Components\TextInput::make('text_button')->label('Текст на кнопке')->required(),
                                        Forms\Components\TextInput::make('text_link')->label('Ссылка')->required(),
                                    ])->columns(2)->collapsible()
                            ]),
                        Tabs\Tab::make('Расписание лекций')
                            ->schema([
                                Forms\Components\Toggle::make('schedule_lesson.is_active')->default(true)->label('Активность')->columnSpanFull(),
                                Repeater::make('schedule_lesson.data')
                                    ->disableLabel()
                                    ->schema([
                                        Forms\Components\TextInput::make('city')->label('Город')->required(),
                                        Forms\Components\TextInput::make('text')->label('Название')->required(),
                                        Forms\Components\TextInput::make('data')->label('Дата')->required(),
                                    ])->columns(2)->collapsible()
                            ]),

                        Tabs\Tab::make('Баннер с коллекцией вебинаров')
                            ->schema([
                                Forms\Components\Toggle::make('second_banner.is_active')->default(true)->label('Активность')->columnSpanFull(),
                                Forms\Components\TextInput::make('second_banner.price')->required()->label('Прайс'),
                                Forms\Components\TextInput::make('second_banner.link')->required()->label('Ссылка'),
                                TinyEditor::make('second_banner.title')->label('Заголовок')->required(),
                                TinyEditor::make('second_banner.description')->label('Описание')->required(),
                                Forms\Components\FileUpload::make('second_banner.image')->label('Изображение')->required()
                            ]),

                        Tabs\Tab::make('Вебинары в записи')
                            ->schema([
                                Forms\Components\Toggle::make('is_active_service')->default(true)->label('Активность')->columnSpanFull(),
                            ])
                    ])->columnSpanFull()

//


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('seo')
                    ->label('Главная страница')
                    ->sortable(false) // Отключаем сортировку для статического текста
                    ->formatStateUsing(function ($record) {
                        return 'Главная страница'; // Замените на ваш статический текст
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
            'index' => Pages\ListHomePages::route('/'),
            'create' => Pages\CreateHomePage::route('/create'),
            'edit' => Pages\EditHomePage::route('/{record}/edit'),
        ];
    }
}
