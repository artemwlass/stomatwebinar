<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentResource\Pages;
use App\Filament\Resources\PaymentResource\RelationManagers;
use App\Models\Payment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;
    protected static ?string $navigationLabel = 'Оплата и возврат';
    protected static ?string $navigationGroup = 'Настройки';
    protected static ?string $breadcrumb = 'Оплата и возврат';
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

                Forms\Components\Section::make('Политика')
                    ->schema([
                        Forms\Components\TextInput::make('title')->label('Заголовок')->required(),
                        Forms\Components\RichEditor::make('text')->label('Текст')->required()
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
            'index' => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayment::route('/create'),
            'edit' => Pages\EditPayment::route('/{record}/edit'),
        ];
    }
}
