<?php

namespace App\Livewire\Home\Components;

use Livewire\Component;

class CtaBannerBlock extends Component
{
    public $home;
    public function render()
    {
        return view('livewire.home.components.cta-banner-block');
    }
}
