<?php

namespace App\Livewire\Account;

use App\Models\EquipmentReview;
use App\Support\AchievementPoints;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Equipment extends Component
{
    public bool $showProposalModal = false;
    public bool $submitted = false;
    public string $phone = '';
    public string $email = '';
    public string $videoUrl = '';
    public string $title = '';
    public string $review = '';
    public bool $confirmation = false;

    public function mount(): void
    {
        $this->phone = (string) (Auth::user()->phone ?? '');
        $this->email = (string) Auth::user()->email;
    }

    public function openProposalModal(): void
    {
        $this->resetValidation();
        $this->showProposalModal = true;
        $this->dispatch('equipment-modal-opened');
    }

    public function closeProposalModal(): void
    {
        $this->showProposalModal = false;
        $this->resetValidation();
        $this->dispatch('equipment-modal-closed');
    }

    public function submitProposal(): void
    {
        $validated = $this->validate([
            'phone' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255'],
            'videoUrl' => ['required', 'url:http,https', 'max:500'],
            'title' => ['required', 'string', 'max:255'],
            'review' => ['required', 'string', 'max:10000'],
            'confirmation' => ['accepted'],
        ], [
            'phone.required' => 'Вкажіть номер телефону.',
            'email.required' => 'Вкажіть електронну пошту.',
            'email.email' => 'Вкажіть коректну електронну пошту.',
            'videoUrl.required' => 'Додайте посилання на відео.',
            'videoUrl.url' => 'Вкажіть коректне посилання на відео.',
            'title.required' => 'Вкажіть назву огляду.',
            'review.required' => 'Напишіть розгорнутий відгук.',
            'confirmation.accepted' => 'Підтвердіть згоду на публікацію.',
        ]);

        EquipmentReview::create([
            'user_id' => Auth::id(),
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'video_url' => $validated['videoUrl'],
            'title' => $validated['title'],
            'review' => $validated['review'],
            'is_approved' => false,
        ]);

        $this->reset(['videoUrl', 'title', 'review', 'confirmation']);
        $this->showProposalModal = false;
        $this->submitted = true;
        $this->dispatch('equipment-modal-closed');
    }

    public function markViewed(int $reviewId): void
    {
        $review = EquipmentReview::query()
            ->where('is_approved', true)
            ->whereNotNull('video_file')
            ->findOrFail($reviewId);

        AchievementPoints::awardOnce(Auth::id(), 'equipment_view', $review, 'Переглянуто огляд: ' . $review->title);
    }

    public function render()
    {
        SEOMeta::setTitle('Огляд обладнання');
        SEOMeta::setDescription('Огляди обладнання для сучасної стоматології.');

        $reviews = EquipmentReview::query()
            ->where('is_approved', true)
            ->whereNotNull('approved_at')
            ->whereNotNull('video_file')
            ->latest('approved_at')
            ->get();

        return view('livewire.account.equipment', compact('reviews'))
            ->layout('components.layouts.account');
    }
}
