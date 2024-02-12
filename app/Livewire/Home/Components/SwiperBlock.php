<?php

namespace App\Livewire\Home\Components;

use Livewire\Component;

class SwiperBlock extends Component
{
    public $home;
    public function render()
    {
        return view('livewire.home.components.swiper-block');
    }
}
