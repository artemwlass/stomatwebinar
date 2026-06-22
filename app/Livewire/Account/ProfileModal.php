<?php

namespace App\Livewire\Account;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;

class ProfileModal extends Component
{
    public bool $isOpen = false;

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

    #[On('open-account-profile-modal')]
    public function open(): void
    {
        $this->resetValidation();
        $this->fillAccountFields();
        $this->isOpen = true;
        $this->dispatch('account-profile-modal-opened');
    }

    public function close(): void
    {
        $this->isOpen = false;
        $this->dispatch('account-profile-modal-closed');
    }

    public function save(): void
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
            'full_name.required' => 'Поле "Прізвище ім\'я по батькові" обов\'язкове.',
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
        $user->birthday = sprintf('%04d-%02d-%02d', $year, (int) $validated['birth_month'], (int) $validated['birth_day']);
        $user->work_place = $validated['work_place'];
        $user->position = $validated['position'];
        $user->specialty = $validated['specialty'];
        $user->account_profile_confirmed_at = $user->account_profile_confirmed_at ?: now();
        $user->save();

        $this->dispatch('account-profile-updated');
        $this->close();
    }

    private function fillAccountFields(): void
    {
        $user = Auth::user();

        $this->full_name = trim(implode(' ', array_filter([$user->surname, $user->name])));
        $this->email = (string) $user->email;
        $this->phone = (string) ($user->phone ?? '');
        $this->country = (string) ($user->country ?? '');
        $this->city = (string) ($user->city ?? '');
        $this->work_place = (string) ($user->work_place ?? '');
        $this->position = (string) ($user->position ?? '');
        $this->specialty = (string) ($user->specialty ?? '');
        $this->birth_day = $user->birthday?->format('d') ?? '';
        $this->birth_month = $user->birthday?->format('m') ?? '';
        $this->birth_year = $user->birthday?->format('Y') ?? '';
    }

    public function render()
    {
        return view('livewire.account.profile-modal');
    }
}
