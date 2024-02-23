<?php

namespace App\Livewire\FreeWebinarPreorder\Components;


use Livewire\Component;

class BannerSecondaryBlock extends Component
{
    public $webinar, $webinar_id;

    public function render()
    {
        return view('livewire.free-webinar-preorder.components.banner-secondary-block');
    }
}
