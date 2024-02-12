<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FreeWebinarResource\Pages;
use App\Filament\Resources\FreeWebinarResource\RelationManagers;
use App\Models\FreeWebinar;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FreeWebinarResource extends Resource
{
    protected static ?string $model = FreeWebinar::class;
    protected static ?string $navigationLabel = 'Вебинары';
    protected static ?string $navigationGroup = 'Бесплатные вебинары';
    protected static ?string $breadcrumb = 'Вебинары';
    protected static ?string $navigationIcon = 'heroicon-m-academic-cap';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('SEO')
                            ->schema([
                                Forms\Components\TextInput::make('name')->label('Название')->required(),
                                Forms\Components\TextInput::make('lead')->label('Ведущий')->required(),
                                Forms\Components\TextInput::make('link')->label('Ссылка')->required()->columnSpanFull(),
                                Forms\Components\FileUpload::make('image')->label('Изображение')->required(
                                )->columnSpanFull()->directory('free-webinar')
                            ])->columns(2),
                    ])->columnSpan(['lg' => 2]),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Статус')
                            ->schema([
                                Forms\Components\Toggle::make('active')
                                    ->label('Активность')
                                    ->default(true),
                                Forms\Components\TextInput::make('order')->label('Порядок сортировки')->required()

                            ]),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')->label('Изображение'),
                Tables\Columns\TextColumn::make('name')->label('Название')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('lead')->label('Ведущий')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('order')->label('Порядок сортировки')->sortable()
            ])
            ->defaultSort('order')
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
            'index' => Pages\ListFreeWebinars::route('/'),
            'create' => Pages\CreateFreeWebinar::route('/create'),
            'edit' => Pages\EditFreeWebinar::route('/{record}/edit'),
        ];
    }
}
