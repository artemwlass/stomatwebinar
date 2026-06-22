<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AccountPageResource\Pages;
use App\Models\AccountPage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AccountPageResource extends Resource
{
    protected static ?string $model = AccountPage::class;
    protected static ?string $navigationLabel = 'Головна кабінету';
    protected static ?string $navigationGroup = 'Аккаунт';
    protected static ?string $breadcrumb = 'Головна кабінету';
    protected static ?string $navigationIcon = 'heroicon-o-user-circle';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Меню шапки')
                    ->schema([
                        Forms\Components\Repeater::make('header_links')
                            ->label('Посилання')
                            ->default([
                                ['label' => 'Найближчий вебінар', 'url' => '/'],
                                ['label' => 'Купити все для ендо', 'url' => '/'],
                                ['label' => 'Безкоштовні вебінари', 'url' => '/'],
                                ['label' => 'Контакти', 'url' => '/'],
                            ])
                            ->minItems(4)
                            ->maxItems(4)
                            ->reorderable(false)
                            ->addable(false)
                            ->deletable(false)
                            ->schema([
                                Forms\Components\TextInput::make('label')
                                    ->label('Назва')
                                    ->required(),
                                Forms\Components\TextInput::make('url')
                                    ->label('Посилання')
                                    ->placeholder('/account/webinar або https://...')
                                    ->required(),
                            ])
                            ->columns(2)
                            ->columnSpanFull(),
                    ]),
                Forms\Components\Section::make('Верхній інформаційний блок')
                    ->schema([
                        Forms\Components\RichEditor::make('header_top_content')
                            ->label('Текст у верхньому блоці')
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'strike',
                                'link',
                                'bulletList',
                                'orderedList',
                                'undo',
                                'redo',
                            ])
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('ID'),
                Tables\Columns\TextColumn::make('updated_at')->label('Оновлено')->dateTime('d.m.Y H:i'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAccountPages::route('/'),
            'create' => Pages\CreateAccountPage::route('/create'),
            'edit' => Pages\EditAccountPage::route('/{record}/edit'),
        ];
    }
}
