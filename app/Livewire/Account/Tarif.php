<?php

namespace App\Livewire\Account;

use App\Models\Webinar;
use Artesaos\SEOTools\Facades\SEOMeta;
use Livewire\Attributes\Url;
use Livewire\Component;

class Tarif extends Component
{
    #[Url(as: 'category')]
    public ?string $selectedCategory = null;

    protected function categories(): array
    {
        return [
            'Стоматологія',
            'Хірургічна стоматологія',
            'Терапевтична стоматологія',
            'Ортопедична стоматологія',
            'Дитяча стоматологія',
            'Пародонтологія',
            'Ортодонтія',
            'Щелепно-лицева хірургія',
        ];
    }

    protected function normalizePrice(?string $value): ?float
    {
        if (! $value) {
            return null;
        }

        $sanitized = preg_replace('/[^\d,\.]/', '', $value);

        if ($sanitized === '') {
            return null;
        }

        $lastCommaPosition = strrpos($sanitized, ',');
        $lastDotPosition = strrpos($sanitized, '.');

        if ($lastCommaPosition !== false && $lastDotPosition !== false) {
            if ($lastCommaPosition > $lastDotPosition) {
                $sanitized = str_replace('.', '', $sanitized);
                $sanitized = str_replace(',', '.', $sanitized);
            } else {
                $sanitized = str_replace(',', '', $sanitized);
            }
        } elseif ($lastCommaPosition !== false) {
            $sanitized = str_replace(',', '.', $sanitized);
        }

        return is_numeric($sanitized) ? (float) $sanitized : null;
    }

    protected function formatPrice(?string $value): ?string
    {
        $normalized = $this->normalizePrice($value);

        if ($normalized === null) {
            return null;
        }

        $decimals = fmod($normalized, 1.0) === 0.0 ? 0 : 2;

        return number_format($normalized, $decimals, '.', ' ') . ' грн';
    }

    public function mount()
    {
        if (! $this->selectedCategory) {
            $this->selectedCategory = $this->categories()[0];
        }
    }

    public function selectCategory(string $category): void
    {
        $this->selectedCategory = $category;
    }

    public function render()
    {
        SEOMeta::setTitle('Пакетні пропозиції');
        SEOMeta::setDescription('Пакетні пропозиції в особистому кабінеті.');

        $categories = $this->categories();

        $seriesWebinars = Webinar::query()
            ->where('is_active', true)
            ->where('is_series_webinars', true)
            ->where('package_category', $this->selectedCategory)
            ->with('seriesWebinars')
            ->orderByDesc('order')
            ->get()
            ->map(function (Webinar $webinar) {
                $currentPrice = $this->normalizePrice($webinar->price);
                $oldPrice = $this->normalizePrice($webinar->old_price);
                $discountPercent = null;

                if ($currentPrice !== null && $oldPrice !== null && $oldPrice > 0 && $oldPrice > $currentPrice) {
                    $discountPercent = (int) round((($oldPrice - $currentPrice) / $oldPrice) * 100);
                }

                $webinar->series_count = $webinar->seriesWebinars->count();
                $webinar->display_lecturers = collect($webinar->lecturers ?? [])
                    ->pluck('name')
                    ->filter()
                    ->values()
                    ->all();
                $webinar->discount_percent = $discountPercent;
                $webinar->formatted_price = $this->formatPrice($webinar->price);
                $webinar->formatted_old_price = $this->formatPrice($webinar->old_price);

                return $webinar;
            });

        return view('livewire.account.tarif', compact('categories', 'seriesWebinars'))
            ->layout('components.layouts.account');
    }
}
