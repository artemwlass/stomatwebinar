<?php

namespace App\Livewire\Home\Components;

use Livewire\Component;

class HighlightBlock extends Component
{
    public $home;
    public function render()
    {
        return view('livewire.home.components.highlight-block');
    }
}
