<?php

namespace App\Livewire\Webinar\Components;

use Livewire\Component;

class BenefitsBlock extends Component
{
    public $webinar;

    public function render()
    {
        return view('livewire.webinar.components.benefits-block');
    }
}
