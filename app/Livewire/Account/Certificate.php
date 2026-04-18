<?php

namespace App\Livewire\Account;

use Artesaos\SEOTools\Facades\SEOMeta;
use Livewire\Component;

class Certificate extends Component
{
    public function render()
    {
        SEOMeta::setTitle('Мої сертифікати');
        SEOMeta::setDescription('Мої сертифікати та майбутні події в особистому кабінеті.');

        return view('livewire.account.certificate')
            ->layout('components.layouts.account');
    }
}
