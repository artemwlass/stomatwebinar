<?php

namespace App\Livewire\Account;

use App\Models\AchievementAction;
use App\Models\AchievementClaim;
use App\Models\AchievementGift;
use App\Models\AchievementLevel;
use App\Support\AchievementPoints;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Achievements extends Component
{
    public bool $showGiftsModal = false;
    public bool $showVoucherModal = false;
    public ?int $selectedLevelId = null;
    public ?int $selectedGiftId = null;
    public ?AchievementClaim $claimedGift = null;

    public function openGifts(int $levelId): void
    {
        $level = AchievementLevel::query()->where('is_active', true)->findOrFail($levelId);
        $existingClaim = AchievementClaim::where('user_id', Auth::id())->where('achievement_level_id', $level->id)->first();

        if ($existingClaim) {
            $this->showClaim($existingClaim->id);
            return;
        }

        if (AchievementPoints::balance(Auth::id()) < $level->points_required || ! $level->gifts()->where('is_active', true)->exists()) {
            return;
        }

        $this->selectedLevelId = $level->id;
        $this->selectedGiftId = $level->gifts()->where('is_active', true)->orderBy('sort')->value('id');
        $this->showGiftsModal = true;
        $this->showVoucherModal = false;
        $this->dispatch('achievement-modal-opened');
    }

    public function selectGift(int $giftId): void
    {
        $valid = AchievementGift::where('id', $giftId)
            ->where('achievement_level_id', $this->selectedLevelId)
            ->where('is_active', true)
            ->exists();

        if ($valid) {
            $this->selectedGiftId = $giftId;
        }
    }

    public function claimGift(): void
    {
        $claim = DB::transaction(function () {
            $level = AchievementLevel::query()->lockForUpdate()->findOrFail($this->selectedLevelId);
            $gift = AchievementGift::query()
                ->where('achievement_level_id', $level->id)
                ->where('is_active', true)
                ->findOrFail($this->selectedGiftId);

            if (AchievementPoints::balance(Auth::id()) < $level->points_required) {
                return null;
            }

            return AchievementClaim::firstOrCreate(
                ['user_id' => Auth::id(), 'achievement_level_id' => $level->id],
                [
                    'achievement_gift_id' => $gift->id,
                    'title_snapshot' => $gift->title,
                    'code_snapshot' => $gift->code,
                    'expires_at' => $gift->validity_days ? now()->addDays($gift->validity_days) : null,
                    'claimed_at' => now(),
                ]
            );
        });

        if (! $claim) {
            return;
        }

        $this->claimedGift = $claim->load('gift');
        $this->showGiftsModal = false;
        $this->showVoucherModal = true;
    }

    public function showClaim(int $claimId): void
    {
        $this->claimedGift = AchievementClaim::with('gift')
            ->where('user_id', Auth::id())
            ->findOrFail($claimId);
        $this->showGiftsModal = false;
        $this->showVoucherModal = true;
        $this->dispatch('achievement-modal-opened');
    }

    public function closeModals(): void
    {
        $this->showGiftsModal = false;
        $this->showVoucherModal = false;
        $this->dispatch('achievement-modal-closed');
    }

    public function render()
    {
        SEOMeta::setTitle('Мої досягнення');
        SEOMeta::setDescription('Баланс балів, рівні та подарунки користувача.');

        $balance = AchievementPoints::balance(Auth::id());
        $actions = AchievementAction::where('is_active', true)->orderBy('sort')->get();
        $levels = AchievementLevel::with(['gifts' => fn ($query) => $query->where('is_active', true)->orderBy('sort')])
            ->where('is_active', true)
            ->orderBy('sort')
            ->get();
        $claims = AchievementClaim::with('gift')->where('user_id', Auth::id())->get()->keyBy('achievement_level_id');
        $modalGifts = $this->selectedLevelId
            ? AchievementGift::where('achievement_level_id', $this->selectedLevelId)->where('is_active', true)->orderBy('sort')->limit(5)->get()
            : collect();

        return view('livewire.account.achievements', compact('balance', 'actions', 'levels', 'claims', 'modalGifts'))
            ->layout('components.layouts.account');
    }
}
