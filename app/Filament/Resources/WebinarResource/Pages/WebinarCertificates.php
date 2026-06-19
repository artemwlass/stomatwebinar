<?php

namespace App\Filament\Resources\WebinarResource\Pages;

use App\Filament\Resources\WebinarResource;
use App\Mail\CertificateMail;
use App\Models\WebinarTestResult;
use App\Support\CertificatePresenter;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Filament\Tables;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Mail;

class WebinarCertificates extends Page implements HasTable
{
    use InteractsWithRecord;
    use InteractsWithTable;

    protected static string $resource = WebinarResource::class;

    protected static string $view = 'filament.resources.webinar-resource.pages.certificates';

    protected static ?string $navigationLabel = 'Сертификаты';

    protected static ?string $title = 'Сертификаты';

    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);

        abort_unless(static::getResource()::canEdit($this->getRecord()), 403);
    }

    public function table(Table $table): Table
    {
        return $table
            ->query($this->getCertificatesQuery())
            ->heading('Полученные сертификаты')
            ->description('Список пользователей, которые успешно прошли тест и получили номер сертификата.')
            ->emptyStateHeading('Пока нет полученных сертификатов')
            ->emptyStateDescription('Когда пользователь пройдет тест, сертификат появится здесь.')
            ->columns([
                Tables\Columns\TextColumn::make('full_name')
                    ->label('ФИО')
                    ->state(fn (WebinarTestResult $record): string => CertificatePresenter::fullName($record) ?: ($record->user?->email ?? '—'))
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->whereHas('user', function (Builder $query) use ($search): void {
                            $query->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                        });
                    }),
                Tables\Columns\TextColumn::make('passed_at')
                    ->label('Дата получения')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('certificate_full_number')
                    ->label('Номер сертификата')
                    ->state(fn (WebinarTestResult $record): string => CertificatePresenter::number($record))
                    ->fontFamily('mono')
                    ->copyable()
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->where('certificate_number', 'like', "%{$search}%")
                            ->orWhereHas('webinar', function (Builder $query) use ($search): void {
                                $query->where('certificate_course_id', 'like', "%{$search}%");
                            });
                    }),
                Tables\Columns\TextColumn::make('webinar.bpr_points')
                    ->label('БПР')
                    ->state(fn (WebinarTestResult $record): string => $record->webinar?->bpr_points
                        ? $record->webinar->bpr_points . ' балів БПР'
                        : '—'),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('Посмотреть')
                    ->icon('heroicon-m-eye')
                    ->iconButton()
                    ->color('gray')
                    ->url(fn (WebinarTestResult $record): string => route('admin.certificates.view', $record))
                    ->openUrlInNewTab(),
                Tables\Actions\Action::make('download')
                    ->label('Скачать')
                    ->icon('heroicon-m-arrow-down-tray')
                    ->iconButton()
                    ->url(fn (WebinarTestResult $record): string => route('admin.certificates.download', $record)),
                Tables\Actions\Action::make('send')
                    ->label('Отправить на почту')
                    ->icon('heroicon-m-envelope')
                    ->iconButton()
                    ->color('success')
                    ->action(fn (WebinarTestResult $record) => $this->sendCertificate($record)),
                Tables\Actions\Action::make('delete_certificate')
                    ->label('Удалить сертификат')
                    ->icon('heroicon-m-trash')
                    ->iconButton()
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Удалить сертификат?')
                    ->modalDescription('Результат теста останется, но сертификат и дата выдачи будут очищены.')
                    ->action(fn (WebinarTestResult $record) => $this->deleteCertificate($record)),
            ])
            ->headerActions([
                Tables\Actions\Action::make('export_excel')
                    ->label('Экспорт Excel')
                    ->icon('heroicon-m-arrow-down-tray')
                    ->url(fn (): string => route('admin.certificates.webinar-export', $this->getRecord())),
            ]);
    }

    public function getTitle(): string | Htmlable
    {
        return __($this->record->title . ' - Сертификаты');
    }

    public function getBreadcrumb(): string
    {
        return 'Сертификаты';
    }

    private function getCertificatesQuery(): Builder
    {
        return WebinarTestResult::query()
            ->with(['user', 'webinar'])
            ->where('webinar_id', $this->getRecord()->getKey())
            ->where('is_passed', true)
            ->whereNotNull('certificate_number')
            ->latest('passed_at');
    }

    private function sendCertificate(WebinarTestResult $record): void
    {
        $record->loadMissing(['user', 'webinar']);

        if (blank($record->user?->email)) {
            Notification::make()
                ->title('У пользователя не указан email')
                ->danger()
                ->send();

            return;
        }

        Mail::to($record->user->email)->send(new CertificateMail($record));

        Notification::make()
            ->title('Сертификат отправлен')
            ->body($record->user->email)
            ->success()
            ->send();
    }

    private function deleteCertificate(WebinarTestResult $record): void
    {
        $record->forceFill([
            'is_passed' => false,
            'passed_at' => null,
            'certificate_number' => null,
        ])->save();

        Notification::make()
            ->title('Сертификат удален')
            ->success()
            ->send();
    }
}
