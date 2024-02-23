<?php

namespace App\Livewire\FreeWebinarPreorder\Components;


use Livewire\Component;

class FaqBlock extends Component
{
    public $webinar;

    public function render()
    {
        return view('livewire.free-webinar-preorder.components.faq-block');
    }
}
