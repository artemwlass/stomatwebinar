<?php

namespace App\Livewire\Account;

use Artesaos\SEOTools\Facades\SEOMeta;
use Livewire\Component;

class WebinarData extends Component
{
    public function render()
    {
        SEOMeta::setTitle('Тестування');
        SEOMeta::setDescription('Тестування в особистому кабінеті.');

        return view('livewire.account.webinar-data')
            ->layout('components.layouts.account', [
                'accountHeaderTop' => false,
            ]);
    }
}
