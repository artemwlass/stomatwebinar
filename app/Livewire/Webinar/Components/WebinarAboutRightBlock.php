<?php

namespace App\Livewire\Webinar\Components;

use Livewire\Component;

class WebinarAboutRightBlock extends Component
{
    public $webinar, $webinar_id;

    public function render()
    {
        return view('livewire.webinar.components.webinar-about-right-block');
    }
}
