<?php

namespace App\Filament\Resources\WebinarResource\Pages;

use App\Filament\Resources\WebinarResource;
use App\Models\WebinarTestResult;
use App\Support\CertificatePresenter;
use App\Support\WebinarTestResultPdf;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Filament\Tables;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class WebinarTests extends Page implements HasTable
{
    use InteractsWithRecord;
    use InteractsWithTable;

    protected static string $resource = WebinarResource::class;

    protected static string $view = 'filament.resources.webinar-resource.pages.tests';

    protected static ?string $navigationLabel = 'Тесты';

    protected static ?string $title = 'Тесты';

    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);

        abort_unless(static::getResource()::canEdit($this->getRecord()), 403);
    }

    public function table(Table $table): Table
    {
        return $table
            ->query($this->getTestResultsQuery())
            ->heading('Результаты тестов')
            ->description('Все попытки пользователей по этому вебинару.')
            ->emptyStateHeading('Пока нет результатов тестов')
            ->emptyStateDescription('Когда пользователь пройдет тест, результат появится здесь.')
            ->columns([
                Tables\Columns\TextColumn::make('user.email')
                    ->label('Почта')
                    ->placeholder('—')
                    ->searchable(),
                Tables\Columns\TextColumn::make('score')
                    ->label('Баллы')
                    ->state(fn (WebinarTestResult $record): string => $this->formatScore($record))
                    ->fontFamily('mono'),
                Tables\Columns\TextColumn::make('full_name')
                    ->label('ФИО')
                    ->state(fn (WebinarTestResult $record): string => CertificatePresenter::fullName($record) ?: '—')
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->whereHas('user', function (Builder $query) use ($search): void {
                            $query->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                        });
                    }),
                Tables\Columns\TextColumn::make('user.country')
                    ->label('Страна')
                    ->placeholder('—'),
                Tables\Columns\TextColumn::make('user.birthday')
                    ->label('Дата рождения')
                    ->date('d.m.Y')
                    ->placeholder('—'),
                Tables\Columns\TextColumn::make('user.work_place')
                    ->label('Место работы')
                    ->placeholder('—'),
                Tables\Columns\TextColumn::make('user.position')
                    ->label('Должность')
                    ->placeholder('—'),
                Tables\Columns\TextColumn::make('completed_at')
                    ->label('Время прохождения')
                    ->state(fn (WebinarTestResult $record): string => ($record->passed_at ?? $record->updated_at)
                        ? ($record->passed_at ?? $record->updated_at)->copy()->timezone(config('app.display_timezone'))->format('d.m.Y H:i')
                        : '—'),
            ])
            ->actions([
                Tables\Actions\Action::make('download_answers')
                    ->label('Скачать PDF с ответами')
                    ->icon('heroicon-m-arrow-down-tray')
                    ->iconButton()
                    ->color('gray')
                    ->url(fn (WebinarTestResult $record): string => route('admin.webinar-test-results.answers-pdf', $record)),
            ]);
    }

    public function getTitle(): string | Htmlable
    {
        return __($this->record->title . ' - Тесты');
    }

    public function getBreadcrumb(): string
    {
        return 'Тесты';
    }

    private function getTestResultsQuery(): Builder
    {
        return WebinarTestResult::query()
            ->with(['user'])
            ->where('webinar_id', $this->getRecord()->getKey())
            ->latest();
    }

    private function formatScore(WebinarTestResult $record): string
    {
        return WebinarTestResultPdf::score($record);
    }

    private function testQuestions(): Collection
    {
        return collect($this->getRecord()->tests ?? [])
            ->filter(fn ($test) => ! empty($test['question']) && ! empty($test['answers']) && is_array($test['answers']))
            ->values();
    }

}
