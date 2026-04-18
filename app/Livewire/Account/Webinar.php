<?php

namespace App\Livewire\Account;

use Artesaos\SEOTools\Facades\SEOMeta;
use Livewire\Component;

class Webinar extends Component
{
    public function render()
    {
        SEOMeta::setTitle('Вебінари у записі');
        SEOMeta::setDescription('Вебінари у записі в особистому кабінеті.');

        return view('livewire.account.webinar')
            ->layout('components.layouts.account');
    }
}
