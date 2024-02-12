<?php

namespace App\Livewire\Webinar\Components;

use Livewire\Component;

class MainFirstBlock extends Component
{
    public $webinar, $webinar_id;

    public function render()
    {
        return view('livewire.webinar.components.main-first-block');
    }
}
