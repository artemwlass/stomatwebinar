<?php

namespace App\Livewire\Account;

use App\Models\FreeWebinar;
use App\Models\Webinar;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
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

        return view('livewire.account.index', compact('webinars', 'webinarsPay'));
    }
}
