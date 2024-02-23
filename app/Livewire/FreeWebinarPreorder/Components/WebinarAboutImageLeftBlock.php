<?php

namespace App\Livewire\FreeWebinarPreorder\Components;


use Livewire\Component;

class WebinarAboutImageLeftBlock extends Component
{
    public $webinar, $webinar_id;

    public function render()
    {
        return view('livewire.free-webinar-preorder.components.webinar-about-image-left-block');
    }
}
