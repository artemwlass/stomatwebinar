<?php

namespace App\Livewire\Account;

use Artesaos\SEOTools\Facades\SEOMeta;
use Livewire\Component;

class Tarif extends Component
{
    public function render()
    {
        SEOMeta::setTitle('Пакетні пропозиції');
        SEOMeta::setDescription('Пакетні пропозиції в особистому кабінеті.');

        return view('livewire.account.tarif')
            ->layout('components.layouts.account');
    }
}
