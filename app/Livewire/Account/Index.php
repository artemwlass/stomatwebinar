<?php

namespace App\Livewire\Account;

use App\Models\FreeWebinar;
use App\Models\Webinar;
use Artesaos\SEOTools\Facades\SEOMeta;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        SEOMeta::setTitle('Курси та вебінари зі стоматології від Ігора Ноєнка');
        SEOMeta::setDescription('Навчальні курси та безкоштовні вебінари зі стоматології. Сертифікати від Ігора Ноєнка. Дитяча стоматологія.');

        $freeWebinars = FreeWebinar::orderBy('order', 'asc')->get();
        $webinars = Webinar::orderByDesc('order')->select('id', 'title', 'order', 'image', 'slug', 'date')->where('is_active', true)->get();

        return view('livewire.account.index', compact('freeWebinars', 'webinars'));
    }
}
