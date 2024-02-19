<?php

namespace App\Livewire\Webinar;

use App\Models\GroupUser;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Show extends Component
{
    public $webinar;

    public function mount($slug)
    {
        $this->webinar = \App\Models\Webinar::where('slug', $slug)->first();

        if (!$this->webinar) {
            abort(404);
        }

        $userWebinarIds = Auth::user()->groups->map(function ($group) {
            return optional($group->webinar)->id;
        });

        // Проверяем, есть ли текущий вебинар среди доступных пользователю
        if (!$userWebinarIds->contains($this->webinar->id)) {
            abort(403); // или другой подход к обработке отсутствия доступа
        }

        SEOMeta::setTitle($this->webinar->seo['title']);
        SEOMeta::setDescription($this->webinar->seo['meta_description']);
        SEOMeta::addKeyword($this->webinar->seo['keywords']);

        OpenGraph::setTitle($this->webinar->seo['og_title']);
        OpenGraph::setDescription($this->webinar->seo['og_description']);
        OpenGraph::addImage(asset('storage/' . $this->webinar->seo['og_image']));
        OpenGraph::setType($this->webinar->seo['og_type']);
        OpenGraph::setUrl($this->webinar->seo['og_url']);
    }

    public function render()
    {
        $accessibleWebinarIds = Auth::user()->groups->map(function ($group) {
            return optional($group->webinar)->id;
        });
        $inaccessibleWebinars = \App\Models\Webinar::where('is_active', true)
            ->whereNotIn('id', $accessibleWebinarIds)
            ->get();
        $closedWebinarDate = GroupUser::where('user_id', Auth::id())
            ->where('group_id', $this->webinar->group->id)
            ->first()
            ->closed_webinar_date;

        
        if ($closedWebinarDate == 'Бессрочно') {
            $daysRemaining = 'Бессрочно';

        } else {
            $closedWebinarDate = Carbon::createFromFormat('Y-m-d', $closedWebinarDate)->startOfDay();
            $currentDate = Carbon::now()->startOfDay();

            $daysRemaining = $currentDate->diffInDays($closedWebinarDate, false);
        }


        return view('livewire.webinar.show', compact('inaccessibleWebinars', 'daysRemaining'));
    }
}
