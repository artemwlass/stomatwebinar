<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FreeWebinarPreorderResource\Pages;
use App\Filament\Resources\FreeWebinarPreorderResource\RelationManagers;
use App\Models\FreeWebinarPreorder;
use App\Models\Webinar;
use Filament\Forms;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FreeWebinarPreorderResource extends Resource
{
    protected static ?string $model = FreeWebinarPreorder::class;

    protected static ?string $navigationLabel = 'Страницы вебинаров';
    protected static ?string $navigationGroup = 'Предзапись на вебинар';
    protected static ?string $breadcrumb = 'Предзапись на вебинар';
    protected static ?string $navigationIcon = 'heroicon-m-academic-cap';

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
                                Forms\Components\TextInput::make('seo.og_url')->label('Og:Url')->required(
                                )->columnSpanFull(),
                                Forms\Components\FileUpload::make('seo.og_image')->label('Og:Image')->required(
                                )->columnSpanFull()->directory('seo')
                            ])->columns(2),

                Tabs::make('Tabs')
                    ->tabs([
                        Tabs\Tab::make('Основные')
                            ->schema([
                                Forms\Components\Section::make('Вебинар')
                                    ->schema([
                                        Forms\Components\TextInput::make('title')
                                            ->label('Название')
                                            ->maxLength('255')
                                            ->required(),
                                        Forms\Components\TextInput::make('slug')
                                            ->label('URL')
                                            ->required()
                                            ->prefix('webinar/')
                                            ->unique(FreeWebinarPreorder::class, 'slug', ignoreRecord: true),
                                    ])->columns(2),
                            ]),
                        Tabs\Tab::make('Блоки вебинара')
                            ->schema([
                                Forms\Components\Section::make()
                                    ->schema([
                                        Forms\Components\Repeater::make('content')
                                            ->label('блоку')
                                            ->disableLabel()
                                            ->schema([
                                                Forms\Components\Select::make('type')->label('Выберите блок')->options([
                                                    '0' => 'Главный (в начале страницы)',
                                                    '1' => 'Преимущества',
                                                    '2' => 'О вебинаре (Картинка слева)',
                                                    '3' => 'Вторичный баннер',
                                                    '4' => 'Вопрос - Ответ',
                                                    '5' => 'О вебинаре (Картинка справа + текст снизу)',
                                                    '6' => 'Слайдер',
                                                    '7' => 'О вебинаре (Картинка слева + текст справа + текст снизу)',
                                                    '8' => 'О вебинаре (Картинка справа)',
                                                    '9' => 'Вебинары для рекомендации',
                                                    '10' => 'Видео',
                                                    '11' => 'Форма',
                                                ])->live(),

                                                Forms\Components\Section::make('Главный блок')->schema([
                                                    Forms\Components\TextInput::make('date')->label('Дата')->required(),
                                                    Forms\Components\TextInput::make('time')->label('Время')->required(),
                                                    Forms\Components\TextInput::make('title')->label('Заголовок')->required(),
                                                    Forms\Components\TextInput::make('price')->label('Прайс')->required(),
                                                    Forms\Components\TagsInput::make('tags')->label('Тэги')->required(),
                                                    Forms\Components\FileUpload::make('banner')->label('Баннер')->directory('webinar')->required()
                                                ])->columns(2)->visible(fn(Forms\Get $get) => ($get('type') == '0')),

                                                Forms\Components\Section::make('Преимущества')->schema([
                                                    Forms\Components\TextInput::make('title')->label('Заголовок')->required(),
                                                    Forms\Components\Textarea::make('description')->label('Описание')->required(),
                                                    Forms\Components\TextInput::make('title2')->label('Заголовок')->required(),
                                                    Forms\Components\Textarea::make('description2')->label('Описание')->required(),
                                                    Forms\Components\TextInput::make('title3')->label('Заголовок')->required(),
                                                    Forms\Components\Textarea::make('description3')->label('Описание')->required(),
                                                ])->columns(2)->visible(fn(Forms\Get $get) => ($get('type') == '1')),

                                                Forms\Components\Section::make('О вебинаре (Картинка слева)')->schema([
                                                    Forms\Components\FileUpload::make('image')->label('Изображение')->directory('webinar')->required(),
                                                    Forms\Components\RichEditor::make('description')->label('Описание')->required(),
                                                ])->columns(2)->visible(fn(Forms\Get $get) => ($get('type') == '2')),

                                                Forms\Components\Section::make('Вторичный баннер')->schema([
                                                    Forms\Components\TextInput::make('lead')->label('Ведущий')->required(),
                                                    Forms\Components\RichEditor::make('title')->label('Заголовок')->required(),
                                                    Forms\Components\TextInput::make('date')->label('Дата')->required(),
                                                    Forms\Components\TextInput::make('time')->label('Время')->required(),
                                                    Forms\Components\TextInput::make('price')->label('Прайс')->required(),
                                                ])->columns(2)->visible(fn(Forms\Get $get) => ($get('type') == '3')),

                                                Forms\Components\Section::make('Вопрос- Ответ')
                                                    ->schema([
                                                        Forms\Components\Toggle::make('active')->default(true)->label('Вопрос - ответ')
                                                    ])->visible(fn(Forms\Get $get) => ($get('type') == '4')),

                                                Forms\Components\Section::make('О вебинаре (Картинка справа + текст снизу)')->schema([
                                                    Forms\Components\FileUpload::make('image')->label('Изображение')->directory('webinar')->columnSpanFull()->required(),
                                                    Forms\Components\RichEditor::make('description')->label('Описание слева')->required(),
                                                    Forms\Components\RichEditor::make('description2')->label('Описание снизу')->required(),
                                                ])->columns(2)->visible(fn(Forms\Get $get) => ($get('type') == '5')),

                                                Forms\Components\Section::make('Слайдер')->schema([
                                                    Forms\Components\FileUpload::make('images')->label('Изображения')->directory('webinar')->multiple()
                                                ])->visible(fn(Forms\Get $get) => ($get('type') == '6')),

                                                Forms\Components\Section::make('О вебинаре (Картинка слева + текст снизу)')->schema([
                                                    Forms\Components\FileUpload::make('image')->label('Изображение')->directory('webinar')->columnSpanFull()->required(),
                                                    Forms\Components\RichEditor::make('description')->label('Описание справа')->required(),
                                                    Forms\Components\RichEditor::make('description2')->label('Описание снизу')->required(),
                                                ])->columns(2)->visible(fn(Forms\Get $get) => ($get('type') == '7')),

                                                Forms\Components\Section::make('О вебинаре (Картинка слева)')->schema([
                                                    Forms\Components\FileUpload::make('image')->label('Изображение')->directory('webinar')->required(),
                                                    Forms\Components\RichEditor::make('description')->label('Описание')->required(),
                                                ])->columns(2)->visible(fn(Forms\Get $get) => ($get('type') == '8')),

                                                Forms\Components\Section::make('Вебинары')->schema([
                                                    Forms\Components\Select::make('webinar1')->label('Выберите вебинар')
                                                        ->options(function () {
                                                            $webinars = Webinar::where('is_active', true)->pluck(
                                                                'title',
                                                                'id'
                                                            )->toArray();

                                                            return $webinars;
                                                        }),
                                                    Forms\Components\Select::make('webinar2')->label('Выберите вебинар')
                                                        ->options(function () {
                                                            $webinars = Webinar::where('is_active', true)->pluck(
                                                                'title',
                                                                'id'
                                                            )->toArray();

                                                            return $webinars;
                                                        }),
                                                    Forms\Components\Select::make('webinar3')->label('Выберите вебинар')
                                                        ->options(function () {
                                                            $webinars = Webinar::where('is_active', true)->pluck(
                                                                'title',
                                                                'id'
                                                            )->toArray();

                                                            return $webinars;
                                                        }),
                                                ])->visible(fn(Forms\Get $get) => ($get('type') == '9')),

                                                Forms\Components\Section::make('Видео')
                                                    ->schema([
                                                        Forms\Components\TextInput::make('video')->required()->label('Ссылка на видео')
                                                    ])->visible(fn(Forms\Get $get) => ($get('type') == '10')),
                                                Forms\Components\Section::make('Форма')
                                                    ->schema([
                                                        Forms\Components\TextInput::make('form_id')
                                                            ->required()
                                                            ->label('ID таблицы эксель (Не забудьте пригласить робота в таблицу)'),

                                                        Forms\Components\Repeater::make('form')
                                                            ->label('Вопросы')
                                                            ->default([])
                                                            ->schema([
                                                                Forms\Components\TextInput::make('form_question')
                                                                    ->label('Вопрос')
                                                                    ->required()
                                                                    ->columnSpanFull(),

                                                                Forms\Components\Select::make('field_type')
                                                                    ->label('Тип ответа')
                                                                    ->options([
                                                                        'text'   => 'Текстовое поле',
                                                                        'select' => 'Список',
                                                                    ])
                                                                    ->default('text'),
                                                            ])
                                                            ->columns(2),


                                                        Forms\Components\Toggle::make('form_enabled')
                                                            ->default(true)
                                                            ->label('Показывать форму'),
                                                    ])
                                                    ->visible(fn(Forms\Get $get) => ($get('type') == '11')),
                                            ])
                                    ])
                            ]),
                    ])->columnSpanFull(),

            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->label('Название')->sortable()->searchable(),
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
            'index' => Pages\ListFreeWebinarPreorders::route('/'),
            'create' => Pages\CreateFreeWebinarPreorder::route('/create'),
            'edit' => Pages\EditFreeWebinarPreorder::route('/{record}/edit'),
        ];
    }
}
