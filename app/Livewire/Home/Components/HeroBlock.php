<?php

namespace App\Livewire\Home\Components;

use Livewire\Component;

class HeroBlock extends Component
{
    public $home;
    public function render()
    {
        return view('livewire.home.components.hero-block');
    }
}
