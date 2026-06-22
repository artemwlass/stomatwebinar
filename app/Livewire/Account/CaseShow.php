<?php

namespace App\Livewire\Account;

use App\Models\ClinicalCase;
use App\Support\AchievementPoints;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;

class CaseShow extends Component
{
    public ClinicalCase $case;
    public string $comment = '';

    public function mount(ClinicalCase $case): void
    {
        abort_if($case->published_at === null, 404);
        $this->case = $case;
        AchievementPoints::awardOnce(Auth::id(), 'case_read', $case, 'Прочитано кейс: ' . $case->title);
    }

    public function addComment(): void
    {
        $validated = $this->validate([
            'comment' => ['required', 'string', 'max:5000'],
        ], [
            'comment.required' => 'Напишіть коментар.',
            'comment.max' => 'Коментар не може бути довшим за 5000 символів.',
        ]);

        $this->case->comments()->create([
            'user_id' => Auth::id(),
            'body' => trim($validated['comment']),
        ]);

        $this->comment = '';
        $this->resetValidation();
    }

    public function render()
    {
        SEOMeta::setTitle($this->case->title);
        SEOMeta::setDescription(Str::of($this->case->content)->stripTags()->limit(160));

        $comments = $this->case->comments()->with('user')->latest()->get();

        return view('livewire.account.case-show', compact('comments'))
            ->layout('components.layouts.account');
    }
}
