<?php

namespace App\Livewire\Account;

use App\Models\AccountPage;
use App\Models\FreeWebinar;
use App\Models\Webinar;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    public $full_name = '';
    public $email = '';
    public $phone = '';
    public $birth_day = '';
    public $birth_month = '';
    public $birth_year = '';
    public $country = '';
    public $city = '';
    public $work_place = '';
    public $position = '';
    public $specialty = '';
    public $account_profile_confirmation = false;
    public $showCertificateModal = false;
    public $dashboardStats = [];

    public function mount()
    {
        $user = Auth::user();
        $accountPage = AccountPage::query()->first();

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
        $this->showCertificateModal = $user->account_profile_confirmed_at === null;

        if ($user->birthday) {
            $this->birth_day = $user->birthday->format('d');
            $this->birth_month = $user->birthday->format('m');
            $this->birth_year = $user->birthday->format('y');
        }

        $this->dashboardStats = $accountPage?->dashboard_stats ?: [
            ['label' => 'Текст', 'value' => '2000'],
            ['label' => 'Текст', 'value' => '350 +'],
            ['label' => 'Текст', 'value' => '15 000'],
        ];
    }

    public function saveAccountProfile()
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
            'account_profile_confirmation' => ['accepted'],
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
            'account_profile_confirmation.accepted' => 'Підтвердіть ознайомлення з правилами вебінару.',
        ]);

        $year = (int) $validated['birth_year'];

        $currentTwoDigitYear = (int) now()->format('y');
        $year += $year <= $currentTwoDigitYear ? 2000 : 1900;

        $birthday = sprintf(
            '%04d-%02d-%02d',
            $year,
            (int) $validated['birth_month'],
            (int) $validated['birth_day']
        );

        if (! checkdate((int) $validated['birth_month'], (int) $validated['birth_day'], $year)) {
            $this->addError('birth_day', 'Вкажіть коректну дату народження.');
            return;
        }

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
        $user->account_profile_confirmed_at = now();
        $user->save();

        $this->showCertificateModal = false;
        $this->dispatch('account-profile-confirmed');
    }

    public function render()
    {
        SEOMeta::setTitle('Курси та вебінари зі стоматології від Ігора Ноєнка');
        SEOMeta::setDescription('Навчальні курси та безкоштовні вебінари зі стоматології. Сертифікати від Ігора Ноєнка. Дитяча стоматологія.');

        $webinars = Webinar::orderByDesc('order')->select('id', 'title', 'order', 'image', 'slug', 'date')->where('is_active', true)->get();

        $webinarsPay = Auth::user()->groups()->whereHas('webinar', function ($query) {
            $query->where('is_preorder', false);
        })->with(['webinar' => function ($query) {
            $query->where('is_preorder', false);
        }])->get()->pluck('webinar');


        $accessibleWebinarIds = Auth::user()->groups->map(function ($group) {
            return optional($group->webinar)->id;
        });
        $webinars = \App\Models\Webinar::where('is_active', true)
            ->whereNotIn('id', $accessibleWebinarIds)
            ->get();

        $nearestWebinars = Webinar::query()
            ->where('is_active', true)
            ->whereNotNull('date_preorder')
            ->whereDate('date_preorder', '>=', now()->toDateString())
            ->orderBy('date_preorder')
            ->limit(3)
            ->get(['id', 'title', 'slug', 'image', 'date_preorder', 'bpr_points']);

        return view('livewire.account.index', compact('webinars', 'webinarsPay', 'nearestWebinars'))
            ->layout('components.layouts.account');
    }
}
