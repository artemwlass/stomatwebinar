<?php

namespace App\Livewire\Account;

use App\Models\ClinicalCase;
use App\Support\AchievementPoints;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class Cases extends Component
{
    use WithFileUploads;

    public bool $showPublishModal = false;
    public string $authorName = '';
    public string $title = '';
    public string $gender = '';
    public string $age = '';
    public string $complaints = '';
    public string $medicalHistory = '';
    public string $examination = '';
    public string $content = '';
    public array $uploads = [];
    public bool $confirmation = false;

    public function mount(): void
    {
        $this->authorName = $this->userDisplayName();
    }

    protected function userDisplayName(): string
    {
        $user = Auth::user();

        return trim(implode(' ', array_filter([$user->surname, $user->name]))) ?: (string) $user->email;
    }

    public function openPublishModal(): void
    {
        $this->resetValidation();
        $this->showPublishModal = true;
        $this->dispatch('case-modal-opened');
    }

    public function closePublishModal(): void
    {
        $this->showPublishModal = false;
        $this->resetValidation();
        $this->dispatch('case-modal-closed');
    }

    public function publish(): void
    {
        $validated = $this->validate([
            'authorName' => ['required', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'gender' => ['nullable', 'string', 'max:100'],
            'age' => ['nullable', 'integer', 'min:0', 'max:120'],
            'complaints' => ['nullable', 'string', 'max:5000'],
            'medicalHistory' => ['nullable', 'string', 'max:5000'],
            'examination' => ['nullable', 'string', 'max:5000'],
            'content' => ['required', 'string', 'max:50000'],
            'uploads' => ['nullable', 'array', 'max:20'],
            'uploads.*' => ['file', 'max:2252800', 'mimetypes:image/jpeg,image/png,image/webp,image/gif,video/mp4,video/quicktime,video/webm'],
            'confirmation' => ['accepted'],
        ], [
            'authorName.required' => 'Вкажіть автора.',
            'title.required' => 'Вкажіть назву кейсу.',
            'age.integer' => 'Вік повинен бути числом.',
            'content.required' => 'Додайте опис кейсу.',
            'uploads.max' => 'Можна завантажити не більше 20 файлів.',
            'uploads.*.mimetypes' => 'Дозволені лише зображення та відео.',
            'confirmation.accepted' => 'Підтвердіть публікацію матеріалів.',
        ]);

        $paths = collect($this->uploads)
            ->map(fn ($upload) => $upload->store('casey', 'public'))
            ->values()
            ->all();

        $case = ClinicalCase::create([
            'user_id' => Auth::id(),
            'author_name' => trim($validated['authorName']),
            'title' => trim($validated['title']),
            'slug' => $this->uniqueSlug($validated['title']),
            'gender' => $validated['gender'] ?: null,
            'age' => filled($validated['age']) ? (int) $validated['age'] : null,
            'complaints' => $validated['complaints'] ?: null,
            'medical_history' => $validated['medicalHistory'] ?: null,
            'examination' => $validated['examination'] ?: null,
            'content' => $validated['content'],
            'media' => $paths,
            'published_at' => now(),
        ]);

        AchievementPoints::awardOnce(Auth::id(), 'case_published', $case, 'Опубліковано власний кейс: ' . $case->title);

        $this->reset([
            'title',
            'gender',
            'age',
            'complaints',
            'medicalHistory',
            'examination',
            'content',
            'uploads',
            'confirmation',
        ]);
        $this->authorName = $this->userDisplayName();
        $this->showPublishModal = false;
        $this->dispatch('case-modal-closed');
    }

    protected function uniqueSlug(string $title): string
    {
        $base = Str::slug($title) ?: 'case';
        $slug = $base;
        $suffix = 2;

        while (ClinicalCase::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $suffix++;
        }

        return $slug;
    }

    public function render()
    {
        SEOMeta::setTitle('Кейси');
        SEOMeta::setDescription('Клінічні кейси користувачів особистого кабінету.');

        $cases = ClinicalCase::query()
            ->withCount('comments')
            ->whereNotNull('published_at')
            ->latest('published_at')
            ->get();

        return view('livewire.account.cases', compact('cases'))
            ->layout('components.layouts.account');
    }
}
