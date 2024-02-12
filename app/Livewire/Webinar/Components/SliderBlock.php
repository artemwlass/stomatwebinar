<?php

namespace App\Livewire\Webinar\Components;

use Livewire\Component;

class SliderBlock extends Component
{
    public $webinar;

    public function render()
    {
        return view('livewire.webinar.components.slider-block');
    }
}
