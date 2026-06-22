<?php

namespace App\Livewire\Account;

use App\Models\Webinar;
use App\Models\WebinarTestResult;
use Artesaos\SEOTools\Facades\SEOMeta;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Url;
use Livewire\Attributes\On;
use Livewire\Component;

class WebinarData extends Component
{
    #[Url(as: 'webinar')]
    public ?int $selectedWebinarId = null;

    public array $answers = [];
    public bool $isSubmitted = false;
    public bool $isPassed = false;
    public int $scorePercent = 0;
    public bool $showDataModal = false;
    public bool $showPassedModal = false;

    public string $full_name = '';
    public string $email = '';
    public string $phone = '';
    public string $birth_day = '';
    public string $birth_month = '';
    public string $birth_year = '';
    public string $country = '';
    public string $city = '';
    public string $work_place = '';
    public string $position = '';
    public string $specialty = '';

    public function mount(): void
    {
        $this->fillAccountFields();
    }

    #[On('account-profile-updated')]
    public function refreshAccountProfile(): void
    {
        $this->fillAccountFields();
    }

    protected function fillAccountFields(): void
    {
        $user = Auth::user();

        $this->full_name = trim(implode(' ', array_filter([
            $user->surname,
            $user->name,
        ])));
        $this->email = (string) $user->email;
        $this->phone = (string) ($user->phone ?? '');
        $this->country = (string) ($user->country ?? '');
        $this->city = (string) ($user->city ?? '');
        $this->work_place = (string) ($user->work_place ?? '');
        $this->position = (string) ($user->position ?? '');
        $this->specialty = (string) ($user->specialty ?? '');

        if ($user->birthday) {
            $this->birth_day = $user->birthday->format('d');
            $this->birth_month = $user->birthday->format('m');
            $this->birth_year = $user->birthday->format('Y');
        }
    }

    protected function combineDateTime($date, $time): ?Carbon
    {
        if (! $date || ! $time) {
            return null;
        }

        return Carbon::parse($date->format('Y-m-d') . ' ' . $time);
    }

    protected function availableTestingWebinars()
    {
        return $this->purchasedTestingWebinars()
            ->filter(fn ($webinar) => $webinar->testing_is_open)
            ->values();
    }

    public function selectWebinar(int $webinarId): void
    {
        $webinar = $this->purchasedTestingWebinars()->firstWhere('id', $webinarId);

        if (! $webinar || ! $webinar->testing_is_open) {
            return;
        }

        $this->selectedWebinarId = $webinarId;
        $this->resetTestState();
        $this->syncStateFromStoredResult();
    }

    public function backToWebinars(): void
    {
        $this->selectedWebinarId = null;
        $this->resetTestState();
    }

    public function resetTestState(): void
    {
        $webinar = $this->selectedWebinar();
        $existingResult = $webinar ? $this->existingResult($webinar->id) : null;

        if ($existingResult && $existingResult->is_passed) {
            $this->answers = $existingResult->answers ?? [];
            $this->isSubmitted = true;
            $this->isPassed = true;
            $this->scorePercent = (int) $existingResult->score_percent;
            $this->showPassedModal = false;

            return;
        }

        $this->answers = [];
        $this->isSubmitted = false;
        $this->isPassed = false;
        $this->scorePercent = 0;
        $this->showPassedModal = false;
    }

    public function openDataModal(): void
    {
        $this->showDataModal = true;
    }

    public function closeDataModal(): void
    {
        $this->showDataModal = false;
    }

    public function closePassedModal()
    {
        $this->showPassedModal = false;

        return redirect()->route('account.certificate');
    }

    public function saveAccountProfile(): void
    {
        $validated = $this->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore(Auth::id())],
            'phone' => ['required', 'string', 'max:255'],
            'birth_day' => ['required', 'digits:2'],
            'birth_month' => ['required', 'digits:2'],
            'birth_year' => ['required', 'digits:4'],
            'country' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'work_place' => ['required', 'string', 'max:255'],
            'position' => ['required', 'string', 'max:255'],
            'specialty' => ['required', 'string', 'max:255'],
        ], [
            'full_name.required' => 'Поле "Прізвище ім\'я по-батькові" обов\'язкове.',
            'email.required' => 'Поле "Електронна пошта" обов\'язкове.',
            'email.email' => 'Невірний формат електронної пошти.',
            'email.unique' => 'Ця електронна пошта вже використовується.',
            'phone.required' => 'Поле "Номер телефону" обов\'язкове.',
            'birth_day.required' => 'Вкажіть день народження.',
            'birth_day.digits' => 'День народження має містити 2 цифри.',
            'birth_month.required' => 'Вкажіть місяць народження.',
            'birth_month.digits' => 'Місяць народження має містити 2 цифри.',
            'birth_year.required' => 'Вкажіть рік народження.',
            'birth_year.digits' => 'Рік народження має містити 4 цифри.',
            'country.required' => 'Поле "Країна" обов\'язкове.',
            'city.required' => 'Поле "Місто" обов\'язкове.',
            'work_place.required' => 'Поле "Місце роботи" обов\'язкове.',
            'position.required' => 'Поле "Займана посада" обов\'язкове.',
            'specialty.required' => 'Оберіть спеціальність.',
        ]);

        $year = (int) $validated['birth_year'];

        if (! checkdate((int) $validated['birth_month'], (int) $validated['birth_day'], $year)) {
            $this->addError('birth_day', 'Вкажіть коректну дату народження.');

            return;
        }

        $birthday = sprintf(
            '%04d-%02d-%02d',
            $year,
            (int) $validated['birth_month'],
            (int) $validated['birth_day']
        );

        $user = Auth::user();
        $fullName = preg_replace('/\s+/u', ' ', trim($validated['full_name']));
        $nameParts = preg_split('/\s+/u', $fullName) ?: [];

        if (count($nameParts) > 1) {
            $user->surname = array_shift($nameParts);
            $user->name = implode(' ', $nameParts);
        } else {
            $user->name = $fullName;
            $user->surname = $user->surname ?: null;
        }

        $user->email = $validated['email'];
        $user->phone = $validated['phone'];
        $user->country = $validated['country'];
        $user->city = $validated['city'];
        $user->birthday = $birthday;
        $user->work_place = $validated['work_place'];
        $user->position = $validated['position'];
        $user->specialty = $validated['specialty'];
        $user->account_profile_confirmed_at = $user->account_profile_confirmed_at ?: now();
        $user->save();

        $this->closeDataModal();
    }

    public function submitTest(): void
    {
        $webinar = $this->selectedWebinar();

        if (! $webinar) {
            return;
        }

        $existingResult = $this->existingResult($webinar->id);

        if ($existingResult && $existingResult->is_passed) {
            $this->answers = $existingResult->answers ?? [];
            $this->isSubmitted = true;
            $this->isPassed = true;
            $this->scorePercent = (int) $existingResult->score_percent;

            return;
        }

        $tests = collect($webinar->tests)
            ->filter(fn ($test) => ! empty($test['question']) && ! empty($test['answers']) && is_array($test['answers']))
            ->values();

        if ($tests->isEmpty()) {
            return;
        }

        $rules = [];

        foreach ($tests as $index => $test) {
            $rules["answers.$index"] = ['required'];
        }

        $this->validate($rules, [
            'answers.*.required' => 'Оберіть відповідь на кожне питання.',
        ]);

        $correctAnswers = 0;

        foreach ($tests as $index => $test) {
            if ((string) ($this->answers[$index] ?? '') === (string) ($test['correct_answer'] ?? '')) {
                $correctAnswers++;
            }
        }

        $totalQuestions = $tests->count();
        $this->scorePercent = (int) round(($correctAnswers / $totalQuestions) * 100);
        $this->isPassed = $this->scorePercent >= 80;
        $this->isSubmitted = true;

        $result = WebinarTestResult::firstOrNew([
            'user_id' => Auth::id(),
            'webinar_id' => $webinar->id,
        ]);

        $result->attempts_count = (int) $result->attempts_count + 1;
        $result->score_percent = $this->scorePercent;
        $result->answers = $this->answers;

        if ($this->isPassed) {
            $result->is_passed = true;
            $result->passed_at = $result->passed_at ?: now();
            $result->certificate_number = $result->certificate_number ?: $this->generateUniqueCertificateNumber();
            $this->showPassedModal = true;
        } else {
            $result->is_passed = false;
            $result->passed_at = null;
            $result->certificate_number = null;
        }

        $result->save();
    }

    protected function selectedWebinar(): ?Webinar
    {
        return $this->purchasedTestingWebinars()
            ->firstWhere('id', $this->selectedWebinarId);
    }

    protected function existingResult(int $webinarId): ?WebinarTestResult
    {
        return WebinarTestResult::query()
            ->where('user_id', Auth::id())
            ->where('webinar_id', $webinarId)
            ->first();
    }

    protected function syncStateFromStoredResult(): void
    {
        $webinar = $this->selectedWebinar();

        if (! $webinar) {
            return;
        }

        $result = $this->existingResult($webinar->id);

        if (! $result) {
            return;
        }

        $this->answers = $result->answers ?? [];
        $this->isSubmitted = true;
        $this->isPassed = (bool) $result->is_passed;
        $this->scorePercent = (int) $result->score_percent;
    }

    protected function generateUniqueCertificateNumber(): string
    {
        do {
            $number = (string) random_int(100000, 999999);
        } while (WebinarTestResult::query()->where('certificate_number', $number)->exists());

        return $number;
    }

    protected function formatCountdown(Carbon $target, Carbon $now): string
    {
        $targetDayStart = $target->copy()->startOfDay();

        if ($now->lt($targetDayStart)) {
            return $now->diffInDays($targetDayStart) . ' дн.';
        }

        $totalSeconds = max(0, $now->diffInSeconds($target, false));
        $hours = intdiv($totalSeconds, 3600);
        $minutes = intdiv($totalSeconds % 3600, 60);
        $seconds = $totalSeconds % 60;

        return sprintf('%02d : %02d : %02d', $hours, $minutes, $seconds);
    }

    protected function purchasedTestingWebinars()
    {
        $now = now();

        return Auth::user()
            ->groups()
            ->with('webinar')
            ->get()
            ->pluck('webinar')
            ->filter(function ($webinar) {
                return $webinar && ! empty($webinar->tests) && is_array($webinar->tests);
            })
            ->unique('id')
            ->values()
            ->map(function (Webinar $webinar) use ($now) {
                $result = WebinarTestResult::query()
                    ->where('user_id', Auth::id())
                    ->where('webinar_id', $webinar->id)
                    ->first();
                $testingStartAt = $this->combineDateTime($webinar->date_testing_start, $webinar->time_testing_start);
                $testingEndAt = $this->combineDateTime($webinar->date_testing_end, $webinar->time_testing_end);

                $statusLabel = 'Тестування відкриється';
                $statusText = $testingStartAt
                    ? $this->formatCountdown($testingStartAt, $now)
                    : 'Тестування закрито';
                $statusExpired = 'Недоступно';
                $statusTargetTs = $testingStartAt?->getTimestampMs();
                $statusDayStartTs = $testingStartAt?->copy()->startOfDay()->getTimestampMs();
                $isOpen = false;

                if ($testingStartAt && $testingStartAt->lte($now) && (! $testingEndAt || $testingEndAt->gt($now))) {
                    $statusLabel = 'Тестування відкрите';
                    $statusText = $testingEndAt ? $this->formatCountdown($testingEndAt, $now) : 'Відкрито';
                    $statusExpired = 'Завершено';
                    $statusTargetTs = $testingEndAt?->getTimestampMs();
                    $statusDayStartTs = $testingEndAt?->copy()->startOfDay()->getTimestampMs();
                    $isOpen = true;
                } elseif ($testingEndAt && $testingEndAt->lte($now)) {
                    $statusLabel = 'Тестування завершено';
                    $statusText = 'Завершено';
                    $statusTargetTs = null;
                    $statusDayStartTs = null;
                }

                if ($result && $result->is_passed) {
                    $statusLabel = 'Тестування пройдено';
                    $statusText = 'Сертифікат доступний';
                    $statusTargetTs = null;
                    $statusDayStartTs = null;
                    $isOpen = false;
                }

                $webinar->testing_status_label = $statusLabel;
                $webinar->testing_status_text = $statusText;
                $webinar->testing_status_expired = $statusExpired;
                $webinar->testing_status_target_ts = $statusTargetTs;
                $webinar->testing_status_day_start_ts = $statusDayStartTs;
                $webinar->testing_is_open = $isOpen;
                $webinar->test_is_passed = (bool) ($result?->is_passed);
                $webinar->test_result = $result;

                return $webinar;
            });
    }

    public function render()
    {
        SEOMeta::setTitle('Тестування');
        SEOMeta::setDescription('Тестування в особистому кабінеті.');

        $testingWebinars = $this->purchasedTestingWebinars();
        $selectedWebinar = $this->selectedWebinar();

        if ($selectedWebinar && ! $selectedWebinar->testing_is_open && ! $selectedWebinar->test_is_passed) {
            $selectedWebinar = null;
            $this->selectedWebinarId = null;
        }

        return view('livewire.account.webinar-data', compact('testingWebinars', 'selectedWebinar'))
            ->layout('components.layouts.account', [
                'accountHeaderTop' => false,
            ]);
    }
}
