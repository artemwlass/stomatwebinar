<?php

namespace App\Livewire\Webinar\Components;

use Livewire\Component;

class FaqBlock extends Component
{
    public $webinar;

    public function render()
    {
        return view('livewire.webinar.components.faq-block');
    }
}
