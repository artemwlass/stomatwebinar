<?php

namespace App\Livewire\FreeWebinarPreorder\Components;


use App\Models\Webinar;
use Livewire\Component;

class Services extends Component
{
    public $webinar;

    public function render()
    {
        $webinarIds = [$this->webinar['webinar1'], $this->webinar['webinar2'], $this->webinar['webinar3']];
        $webinars = Webinar::find($webinarIds);

        return view('livewire.free-webinar-preorder.components.services', compact('webinars'));
    }
}
