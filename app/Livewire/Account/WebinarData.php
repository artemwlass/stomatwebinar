<?php

namespace App\Livewire\Account;

use App\Models\Webinar;
use Artesaos\SEOTools\Facades\SEOMeta;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Url;
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

        $availableWebinars = $this->availableTestingWebinars();

        if ($availableWebinars->isEmpty()) {
            $this->selectedWebinarId = null;

            return;
        }

        if (! $this->selectedWebinarId || ! $availableWebinars->contains('id', $this->selectedWebinarId)) {
            $this->selectedWebinarId = $availableWebinars->first()->id;
        }
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
            $this->birth_year = $user->birthday->format('y');
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
        $now = now();

        return Auth::user()
            ->groups()
            ->with('webinar')
            ->get()
            ->pluck('webinar')
            ->filter(function ($webinar) use ($now) {
                if (! $webinar || empty($webinar->tests) || ! is_array($webinar->tests)) {
                    return false;
                }

                $testingStartAt = $this->combineDateTime($webinar->date_testing_start, $webinar->time_testing_start);
                $testingEndAt = $this->combineDateTime($webinar->date_testing_end, $webinar->time_testing_end);

                if ($testingStartAt && $testingStartAt->gt($now)) {
                    return false;
                }

                if ($testingEndAt && $testingEndAt->lt($now)) {
                    return false;
                }

                return true;
            })
            ->unique('id')
            ->values();
    }

    public function selectWebinar(int $webinarId): void
    {
        if (! $this->availableTestingWebinars()->contains('id', $webinarId)) {
            return;
        }

        $this->selectedWebinarId = $webinarId;
        $this->resetTestState();
    }

    public function resetTestState(): void
    {
        $this->answers = [];
        $this->isSubmitted = false;
        $this->isPassed = false;
        $this->scorePercent = 0;
    }

    public function openDataModal(): void
    {
        $this->showDataModal = true;
    }

    public function closeDataModal(): void
    {
        $this->showDataModal = false;
    }

    public function saveAccountProfile(): void
    {
        $validated = $this->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore(Auth::id())],
            'phone' => ['required', 'string', 'max:255'],
            'birth_day' => ['required', 'digits:2'],
            'birth_month' => ['required', 'digits:2'],
            'birth_year' => ['required', 'digits:2'],
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
            'birth_year.digits' => 'Рік народження має містити 2 цифри.',
            'country.required' => 'Поле "Країна" обов\'язкове.',
            'city.required' => 'Поле "Місто" обов\'язкове.',
            'work_place.required' => 'Поле "Місце роботи" обов\'язкове.',
            'position.required' => 'Поле "Займана посада" обов\'язкове.',
            'specialty.required' => 'Оберіть спеціальність.',
        ]);

        $year = (int) $validated['birth_year'];
        $currentTwoDigitYear = (int) now()->format('y');
        $year += $year <= $currentTwoDigitYear ? 2000 : 1900;

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
    }

    protected function selectedWebinar(): ?Webinar
    {
        return $this->availableTestingWebinars()
            ->firstWhere('id', $this->selectedWebinarId);
    }

    public function render()
    {
        SEOMeta::setTitle('Тестування');
        SEOMeta::setDescription('Тестування в особистому кабінеті.');

        $availableWebinars = $this->availableTestingWebinars();
        $selectedWebinar = $this->selectedWebinar();

        return view('livewire.account.webinar-data', compact('availableWebinars', 'selectedWebinar'))
            ->layout('components.layouts.account', [
                'accountHeaderTop' => false,
            ]);
    }
}
