<?php

namespace App\Livewire\FreeWebinarPreorder\Components;

use Livewire\Component;

class MainFirstBlock extends Component
{
    public $webinar, $webinar_id;

    public function render()
    {
        return view('livewire.free-webinar-preorder.components.main-first-block');
    }
}
