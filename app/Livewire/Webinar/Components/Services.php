<?php

namespace App\Livewire\Webinar\Components;

use App\Models\Webinar;
use Livewire\Component;

class Services extends Component
{
    public $webinar;

    public function render()
    {
        $webinarIds = [$this->webinar['webinar1'], $this->webinar['webinar2'], $this->webinar['webinar3']];
        $webinars = Webinar::find($webinarIds);

        return view('livewire.webinar.components.services', compact('webinars'));
    }
}
